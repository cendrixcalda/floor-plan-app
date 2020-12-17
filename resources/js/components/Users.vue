<style lang="scss" scoped>
@import "@/_variables.scss";

.options-container {
  @include flexCenteredXY;
  max-width: 100vw;
  margin: 30px 0 5px 0;

  .option-row {
    display: flex;
    justify-content: space-between;
    width: 90%;
  }
}

// Dropdown
.dropdown {
  border: none;
  outline: none;
  background: $secColor;

  & > button {
    border: 1px solid $lightGray;
    background: $secColor;
    outline: none;

    &:focus {
      border-color: $priColor;
      background: $secColor;
    }
  }

  .dropdown-toggle {
    &::after {
      position: relative;
      float: right;
      top: 8px;
    }

    &:focus {
      box-shadow: none;
    }
  }

  .dropdown-menu {
    & > button {
      outline: none;
      &:focus {
        background: $shadowColor;
      }

      &:active {
        background: $priColor;
      }
    }
  }
}

// Checkbox
.custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
  background-color: $priColor !important;
  border-color: $priColor !important;
}

.custom-checkbox
  .custom-control-input:checked:focus
  ~ .custom-control-label::before {
  box-shadow: 0 0 0 1px #fff, 0 0 0 0.2rem $priColor;
}
.custom-checkbox .custom-control-input:focus ~ .custom-control-label::before {
  box-shadow: 0 0 0 1px #fff, 0 0 0 0.2rem $inactivePriColor;
}
.custom-checkbox .custom-control-input:active ~ .custom-control-label::before {
  background-color: $inactivePriColor;
}
</style>

<template>
  <main v-if="columns.length">
    <notifications-overlay
      :notif-message="notifMessage"
      :notif-type="notifType"
      :key="notifCounter"
    ></notifications-overlay>
    <section class="options-container">
      <div class="option-row">
        <div class="dropdown">
          <button
            class="btn btn-light dropdown-toggle"
            type="button"
            id="length"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            {{ tableData.length }}
          </button>
          <div class="dropdown-menu" aria-labelledby="length">
            <button
              class="dropdown-item"
              @click="(tableData.length = records), getUsers()"
              v-for="(records, index) in perPage"
              :key="index"
              :value="records"
            >
              {{ records }}
            </button>
          </div>
        </div>
      </div>
    </section>
    <users-datatable :columns="filterArray(columns, excludedColumns)">
      <tbody>
        <tr>
          <td
            v-for="column in filterArray(columns, excludedFirstRowColumns)"
            :key="column"
          >
            <input
              type="text"
              ref="firstCell"
              class="input"
              @input="objEmptyPropertyRemover(insertData)"
              v-model.trim="insertData[column]"
              autofocus
              :disabled="column == 'user_type'"
              v-if="!checkBoxColumns.includes(column)"
            />
            <div
              class="custom-control custom-checkbox"
              v-if="checkBoxColumns.includes(column)">
              <input
                type="checkbox"
                class="custom-control-input"
                :id="column+'_insert'"
                :disabled="column == 'floor_plan_edit_privilege' && !insertData['floor_plan_access']"
                v-model="insertData[column]"
                @change="objEmptyPropertyRemover(insertData)"
                v-on="column == 'floor_plan_access' ? { change: () => onChangeFloorPlanAccessInsert(insertData[column]) } : {}"
              />
              <label class="custom-control-label" :for="column+'_insert'">Allow</label>
            </div>
          </td>
          <td>
            <button
              title="Clear all"
              type="button"
              class="options"
              :disabled="!(Object.keys(insertData).length - 1)"
              @click="clearFirstRow()"
            >
              <i class="fas fa-backspace"></i>
            </button>
          </td>
          <td>
            <button title="Add new user" type="button" class="options" @click="insertUser()">
              <i class="fas fa-plus"></i>
            </button>
          </td>
        </tr>
        <tr v-for="(user, userKey) in users" :key="userKey">
          <td
            v-for="(value, key) in filterObjectProperties(
              user,
              excludedColumns
            )"
            :key="key"
          >
            <input
              class="input"
              type="text"
              v-model.trim="user[key]"
              @focus="previousValue = value"
              @blur="updateUser(user.id, key, value)"
              :disabled="key == 'user_type'"
              v-if="!checkBoxColumns.includes(key)"
            />
            <div
              class="custom-control custom-checkbox"
              v-if="checkBoxColumns.includes(key)">
              <input
                type="checkbox"
                class="custom-control-input"
                :id="key+user.id"
                v-model="user[key]"
                :disabled="user.user_type == 'Admin' || (key == 'floor_plan_edit_privilege' && !user['floor_plan_access'])"
                @change="updateUser(user.id, key, user[key])"
                v-on="key == 'floor_plan_access' ? { change: () => onChangeFloorPlanAccess(user[key], userKey) } : {}"
              />
              <label class="custom-control-label" :for="key+user.id">Allow</label>
            </div>
          </td>
          <td></td>
          <td>
            <button
              title="Delete user"
              type="button"
              class="options"
              :disabled="user.user_type == 'Admin'"
              @click="deleteUser(user.id)"
            >
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
        <tr v-if="!users.length">
          <div class="no-data">No data</div>
        </tr>
      </tbody>
    </users-datatable>
    <pagination
      :pagination="pagination"
      @prev="getUsers(pagination.prevPageUrl)"
      @index="getUsers(pagination.path + '?page=' + $event)"
      @next="getUsers(pagination.nextPageUrl)"
    ></pagination>
  </main>
</template>

<script>
import NotificationsOverlay from "./Notifications-Overlay";
import UsersDatatable from "./UsersDatatable.vue";
import Pagination from "./Pagination.vue";

export default {
  components: {
    "notifications-overlay": NotificationsOverlay,
    "users-datatable": UsersDatatable,
    pagination: Pagination,
  },
  data() {
    return {
      currentUrlSegment: "",
      notifMessage: "",
      notifType: "",
      notifCounter: 0,
      columns: [],
      users: [],
      perPage: ["10", "25", "50", "100"],
      tableData: {
        requestCounter: 0,
        length: 10,
        search: {},
      },
      insertData: {},
      excludedColumns: [
        "id", 
        "password",
        "created_at", 
        "updated_at", 
        "deleted_at"
      ],
      excludedFirstRowColumns: [
        "id",
        "password",
        "created_at",
        "updated_at",
        "deleted_at",
      ],
      checkBoxColumns: [
        "adss_content_manager_access",
        "floor_plan_access",
        "floor_plan_edit_privilege",
      ],
      previousValue: null,
      pagination: {
        lastPage: "",
        currentPage: "",
        total: "",
        lastPageUrl: "",
        nextPageUrl: "",
        prevPageUrl: "",
        path: "",
        from: "",
        to: "",
      },
    };
  },
  created() {
    this.currentUrlSegment = window.location.pathname.split('/')[1];
  },
  mounted() {
    this.getUserColumns();
    this.getUsers();
  },
  methods: {
    getUserColumns(url = this.currentUrlSegment+"/columns") {
      axios
        .get(url)
        .then((response) => {
          this.columns = response.data;
          this.setInsertData();
        })
        .catch((errors) => {
          this.notifMessage = 
            "Error encountered while getting users columns.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    getUsers(url = this.currentUrlSegment+"/data") {
      this.tableData.requestCounter++;
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          if (this.tableData.requestCounter == data.requestCounter) {
            this.users = data.data.data;
            this.configPagination(data.data);
          }
        })
        .catch((errors) => {
          this.notifMessage =
              "Error encountered while getting users.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    insertUser(url = this.currentUrlSegment+"/insert") {
      let formData = new FormData();

      // Insert data validations
      if(!this.insertData.username) {
          this.notifMessage = "Username is required.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if(!this.insertData.plain_password) {
          this.notifMessage = "Password is required.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if(this.insertData.username.length < 8) {
          this.notifMessage = "Username must be at least 8 characters long.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if(this.insertData.plain_password.length < 8) {
          this.notifMessage = "Password must be at least 8 characters long.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if(this.hasWhiteSpace(this.insertData.username)) {
          this.notifMessage = "Whitespace is not allowed. Please remove whitespace in username.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if(this.hasWhiteSpace(this.insertData.plain_password)) {
          this.notifMessage = "Whitespace is not allowed. Please remove whitespace in password.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else {
        Object.entries(this.insertData).forEach(([key, val]) => {
          formData.append("details[" + key + "]", JSON.stringify(val));
        });
      }

      // for (var pair of formData.entries()) {
      //   console.log(pair[0] + ", " + pair[1]);
      // }

      axios
        .post(url, formData)
        .then((response) => {
          if (response) {
            this.notifMessage = response.data.notifMessage;
            this.notifType = response.data.notifType;
            this.notifCounter++;

            if (response.data.notifType == "success") {
              this.clearFirstRow();
              this.getUsers(
                this.pagination.path + "?page=" + this.pagination.currentPage
              );
            }
          }
        })
        .catch((errors) => {
          this.notifMessage = "Error encountered while inserting user.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    deleteUser(id, url = this.currentUrlSegment+"/delete") {
      if (confirm("Are you sure you want to remove this user?")) {
        axios
          .post(url, { id: id })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.getUsers(
                  this.pagination.path + "?page=" + this.pagination.currentPage
                );
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while deleting user.";
            this.notifType = "error";
            this.notifCounter++;
          });
      }
    },
    updateUser(id, key, value, url = this.currentUrlSegment+"/update") {
      value = value === '' ? null : value;
      
      if (value != this.previousValue) {

        // Insert data validations
        if(key == 'username') {
          if(!value) {
            this.notifMessage = "Username is required.";
            this.notifType = "warning";
            this.notifCounter++;

            return;
          } else if(value.length < 8) {
            this.notifMessage = "Username must be at least 8 characters long.";
            this.notifType = "warning";
            this.notifCounter++;

            return;
          } else if(this.hasWhiteSpace(value)) {
            this.notifMessage = "Whitespace is not allowed. Please remove whitespace in username.";
            this.notifType = "warning";
            this.notifCounter++;

            return;
          }
        } else if(key == 'plain_password') {
          if(!value) {
            this.notifMessage = "Password is required.";
            this.notifType = "warning";
            this.notifCounter++;

            return;
          } else if(value.length < 8) {
            this.notifMessage = "Password must be at least 8 characters long.";
            this.notifType = "warning";
            this.notifCounter++;

            return;
          } else if(this.hasWhiteSpace(value)) {
            this.notifMessage = "Whitespace is not allowed. Please remove whitespace in username.";
            this.notifType = "warning";
            this.notifCounter++;

            return;
          }
        }

        axios
          .post(url, { id: id, key: key, value: value })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.getUsers(
                  this.pagination.path + "?page=" + this.pagination.currentPage
                );
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while updating user.";
            this.notifType = "error";
            this.notifCounter++;
          });
      }
    },
    configPagination(data) {
      this.pagination.lastPage = data.last_page;
      this.pagination.currentPage = data.current_page;
      this.pagination.total = data.total;
      this.pagination.lastPageUrl = data.last_page_url;
      this.pagination.nextPageUrl = data.next_page_url;
      this.pagination.prevPageUrl = data.prev_page_url;
      this.pagination.path = data.path;
      this.pagination.from = data.from;
      this.pagination.to = data.to;
    },
    filterArray(array, excludedElements) {
      return array.filter((element) => !excludedElements.includes(element));
    },
    filterObjectProperties(obj, excludedProperties) {
      return Object.keys(obj)
        .filter((k) => !excludedProperties.includes(k))
        .map((k) => Object.assign({}, { [k]: obj[k] }))
        .reduce((res, o) => Object.assign(res, o), {});
    },
    objEmptyPropertyRemover(obj) {
      Object.entries(obj).forEach(([key, val]) => {
        if (val == null || val == undefined || val == "" || val == false) delete obj[key];
      });
    },
    hasWhiteSpace(s) {
      return /\s/g.test(s);
    },
    clearFirstRow() {
      if (this.isSearching) {
        this.getFloorPlans(
          this.pagination.path + "?page=" + this.pagination.currentPage
        );
      } else {
        this.setInsertData();
        this.houseImageShow = false;
        this.$nextTick(() => {
          this.houseImageShow = true;
        });
        this.floorPlanImageShow = false;
        this.$nextTick(() => {
          this.floorPlanImageShow = true;
        });
        this.fileShow = false;
        this.$nextTick(() => {
          this.fileShow = true;
        });

        this.houseImages = [];
        this.floorPlanImages = [];
        this.files = [];
      }
    },
    setInsertData() {
      this.insertData = {};
      this.insertData.user_type = 'User';
    },
    onChangeFloorPlanAccessInsert(value) {
      if(!value) {
        this.insertData['floor_plan_edit_privilege'] = false;
        this.objEmptyPropertyRemover(this.insertData);
      }
    },
    onChangeFloorPlanAccess(value, userKey) {
      if(!value) {
        this.users[userKey]['floor_plan_edit_privilege'] = 0;
      }
    }
  },
};
</script>
