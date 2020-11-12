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

    .mode {
      display: flex;
      border: 1px solid $lightGray;

      button {
        outline: none;
        border: none;
        margin: 0;
        padding: 5px 15px;
        background: $inactivePriColor;
        color: $secColor;

        &:hover:not(.active),
        &:focus:not(.active) {
          box-shadow: 0 0 8px $priColor;
        }

        &.active {
          background: $priColor;
          color: $secColor;
        }
      }
    }
  }
}

.file-inputs {
  padding: 4px 3px 0 !important;
}

.file-count-col {
  padding: 11px 15px !important;
}

//Preview styles
.preview-container {
  position: fixed;
  @include flexCenteredXY;
  flex-direction: column;
  top: 0;
  z-index: 2;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.3);
  padding: 10px;

  .preview {
    width: 100%;
    max-width: 900px;
    min-height: 90vh;
    overflow-y: auto;
    background: $secColor;
    padding: 20px 10px 10px;

    .preview-section {
      margin-bottom: 30px;
      .preview-section-title {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 16px;
        border-bottom: 1px solid $lightGray;
        margin-bottom: 10px;
      }

      .preview-section-images {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
          grid-gap: 5px;
          width: 100%;
          margin-bottom: 10px;

          .preview-section-image-container {
            width: 400px;
            margin: 5px auto;

            img {
              width: 100%;
              height: 250px;
            }
          }
      }
    }
  }

  .close-container {
    display: flex;
    justify-content: flex-end;
    width: 100%;
    max-width: 900px;
    background: $secColor;
    padding: 5px;
    border-bottom: 1px solid $lightGray;

    .close:before {
      content: "✕";
    }
    .close {
      font-size: 18px;
      cursor: pointer;
      padding: 4px 6px;
      border-radius: 50%;

      &:hover,
      &:focus {
        background: $shadowColor;
      }
    }
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

// File input
.custom-file {
  z-index: 0;
  overflow: hidden;

  .custom-file-input {
    &:focus ~ .custom-file-label,
    &:active ~ .custom-file-label {
      border-color: $priColor;
      box-shadow: none;
    }
  }

  .custom-file-label {
    height: 38px;
    padding: 7px 10px;
    outline: none;
    border: none;
    border: 1px solid $lightGray;
    border-radius: 0;
    color: $terColor;
    max-width: initial;

    &::after {
      height: 100%;
      border-radius: 0;
      padding: 7px 10px;
    }
  }
}

@media (max-width: 470px) {
  .preview-section-images {
    display: flex !important;
    flex-direction: column;

    .preview-section-image-container {
      width: 100% !important;
    }
  }
}

@media (max-width: 340px) {
  .preview-section-image-container {
    img {
      height: 200px !important;
    }
  }
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
              @click="(tableData.length = records), getFloorPlans()"
              v-for="(records, index) in perPage"
              :key="index"
              :value="records"
            >
              {{ records }}
            </button>
          </div>
        </div>
        <div class="mode">
          <button
            :class="{ active: isSearching }"
            :disabled="isSearching"
            @click="switchMode(true), clearFirstRow()"
          >
            Search
          </button>
          <button
            :class="{ active: !isSearching }"
            :disabled="!isSearching"
            @click="
              switchMode(false),
                setSearchData(),
                getFloorPlans(),
                clearFirstRow()
            "
          >
            Insert
          </button>
        </div>
      </div>
    </section>
    <datatable :columns="filterArray(columns, excludedColumns)">
      <tbody>
        <tr v-if="isSearching">
          <td
            class="insert-search"
            v-for="column in filterArray(columns, excludedFirstRowColumns)"
            :key="column"
          >
            <input
              ref="firstCell"
              class="input"
              type="text"
              v-model.trim="tableData.search[column]"
              @input="getFloorPlans()"
              autofocus
            />
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <button
              type="button"
              class="options"
              :disabled="!Object.keys(tableData.search).length"
              @click="clearFirstRow()"
            >
              <i class="fas fa-backspace"></i>
            </button>
          </td>
        </tr>
        <tr v-else>
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
            />
          </td>
          <td class="file-inputs">
            <div class="custom-file">
              <input
                type="file"
                ref="house_images"
                class="custom-file-input"
                id="house_images"
                accept="image/*"
                multiple
                v-if="houseImageShow"
                @change="saveHouseImages()"
              />
              <label class="custom-file-label" for="house_images">{{
               houseImageUploadLabel()
              }}</label>
            </div>
          </td>
          <td class="file-inputs">
            <div class="custom-file">
              <input
                type="file"
                ref="floor_plan_images"
                class="custom-file-input"
                id="floor_plan_images"
                accept="image/*"
                multiple
                v-if="floorPlanImageShow"
                @change="saveFloorPlanImages()"
              />
              <label class="custom-file-label" for="floor_plan_images">{{
               floorPlanImageUploadLabel()
              }}</label>
            </div>
          </td>
          <td>
            <button type="button" class="options" @click="insertFloorPlan()">
              <i class="fas fa-plus"></i>
            </button>
          </td>
          <td>
            <button
              type="button"
              class="options"
              :disabled="!Object.keys(insertData).length && !houseImages.length  && !floorPlanImages.length"
              @click="clearFirstRow()"
            >
              <i class="fas fa-backspace"></i>
            </button>
          </td>
        </tr>
        <tr v-for="floorPlan in floorPlans" :key="floorPlan.id">
          <td
            v-for="(value, key) in filterObjectProperties(
              floorPlan,
              excludedColumns
            )"
            :key="key"
          >
            <input
              class="input"
              type="text"
              v-model.trim="floorPlan[key]"
              @focus="previousValue = value"
              @blur="updateFloorPlan(floorPlan.id, key, value)"
            />
          </td>
          <td class="file-count-col">{{ floorPlan.house_image.length ? floorPlan.house_image.length + ' images' : 'no image' }}</td>
          <td class="file-count-col">{{ floorPlan.floor_plan_image.length ? floorPlan.floor_plan_image.length + ' images' : 'no image' }}</td>
          <td>
            <button type="button" class="options" @click="viewFloorPlanPreview(floorPlan.id)">
              <i class="fas fa-eye"></i>
            </button>
          </td>
          <td>
            <button
              type="button"
              class="options"
              @click="deleteFloorPlan(floorPlan.id)"
            >
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
        <tr v-if="!floorPlans.length">
          <div class="no-data">No data</div>
        </tr>
      </tbody>
    </datatable>
    <pagination
      :pagination="pagination"
      @prev="getFloorPlans(pagination.prevPageUrl)"
      @index="getFloorPlans(pagination.path + '?page=' + $event)"
      @next="getFloorPlans(pagination.nextPageUrl)"
    ></pagination>
    <transition name="fade">
      <div class="preview-container" v-if="showPreview">
        <div class="close-container">
          <span class="close" @click="closePreview"></span>
        </div>
        <div class="preview">

          <div class="preview-section">
            <div class="preview-section-title">
              Tracking Id
            </div>
            <div class="px-3">{{ selectedFloorPlan.tracking_id }}</div>
          </div>

          <div class="preview-section">
            <div class="preview-section-title">
              House Images
            </div>
            <div class="preview-section-images">
              <div
              class="preview-section-image-container"
                v-for="(houseImage, index) in selectedFloorPlan.house_image"
                :key="index">
                <img :src="'images/house_images/' + houseImage['title']" />
              </div>
            </div>
          </div>

          <div class="preview-section">
            <div class="preview-section-title">
              Floor Plan Images
            </div>
            <div class="preview-section-images">
              <div
                class="preview-section-image-container"
                v-for="(floorPlanImage, index) in selectedFloorPlan.floor_plan_image"
                :key="index">
                <img :src="'images/floor_plan_images/' + floorPlanImage['title']" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </main>
</template>

<script>
import NotificationsOverlay from "./Notifications-Overlay";
import Datatable from "./Datatable.vue";
import Pagination from "./Pagination.vue";

export default {
  components: {
    "notifications-overlay": NotificationsOverlay,
    datatable: Datatable,
    pagination: Pagination,
  },
  data() {
    return {
      notifMessage: "",
      notifType: "",
      columns: [],
      floorPlans: [],
      perPage: ["10", "25", "50", "100"],
      tableData: {
        requestCounter: 0,
        length: 10,
        search: {},
      },
      insertData: {},
      houseImages: [],
      floorPlanImages: [],
      autocadFiles: [],
      excludedColumns: ["id", "house_image", "floor_plan_image", "autocadFile", "created_at", "updated_at", "deleted_at"],
      excludedFirstRowColumns: [
        "id",
        "house_images",
        "floor_plan_images",
        "autocadFiles",
        "created_at",
        "updated_at",
        "deleted_at",
      ],
      selectedFloorPlan: null,
      isSearching: true,
      notifCounter: 0,
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
      houseImageShow: true,
      floorPlanImageShow: true,
      autocadImageShow: true,
      showPreview: false,
    };
  },
  mounted() {
    this.getFloorPlanColumns();
    this.getFloorPlans();
  },
  methods: {
    getFloorPlanColumns(url = "/get-floor-plan-columns") {
      axios
        .get(url)
        .then((response) => {
          this.columns = response.data;
          this.setSearchData();
          this.setInsertData();
        })
        .catch((errors) => {
          this.notifMessage =
              "Error encountered while getting floor plan columns.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    getFloorPlans(url = "/get-floor-plans") {
      this.tableData.requestCounter++;
      this.objEmptyPropertyRemover(this.tableData.search);
      axios
        .get(url, { params: this.tableData })
        .then((response) => {
          let data = response.data;
          if (this.tableData.requestCounter == data.requestCounter) {
            this.floorPlans = data.data.data;
            this.configPagination(data.data);
          }
        })
        .catch((errors) => {
          this.notifMessage =
              "Error encountered while getting floor plan records.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    insertFloorPlan(url = "/insert-floor-plan") {
      let formData = new FormData();

      // Insert data validations
      if(!this.insertData.tracking_id) {
          this.notifMessage = "Tracking id is required.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if (!(Object.keys(this.insertData).length - 1)) {
        this.notifMessage = "No details provided for this floor plan.";
        this.notifType = "warning";
        this.notifCounter++;

        return;
      } else if(!this.houseImages.length) {
          this.notifMessage = "No house image uploaded for this floor plan.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else if (!this.floorPlanImages.length) {
          this.notifMessage = "No floor plan image uploaded for this floor plan.";
          this.notifType = "warning";
          this.notifCounter++;

          return;
      } else {
        Object.entries(this.insertData).forEach(([key, val]) => {
          formData.append("details[" + key + "]", JSON.stringify(val));
        });

        this.houseImages.forEach((image, index) => {
          formData.append("house_images[" + index + "]", image);
        });

        this.floorPlanImages.forEach((image, index) => {
          formData.append("floor_plan_images[" + index + "]", image);
        });
      }

      // for (var pair of formData.entries()) {
      //   console.log(pair[0] + ", " + pair[1]);
      // }

      const config = {
        header: {
          "Content-Type": "multipart/form-data",
        },
      };

      axios
        .post(url, formData, config)
        .then((response) => {
          if (response) {
            this.notifMessage = response.data.notifMessage;
            this.notifType = response.data.notifType;
            this.notifCounter++;

            if (response.data.notifType == "success") {
              this.clearFirstRow();
              this.getFloorPlans(
                this.pagination.path + "?page=" + this.pagination.currentPage
              );
            }
          }
        })
        .catch((errors) => {
          this.notifMessage = "Error encountered while inserting new floor plan.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    deleteFloorPlan(id, url = "/delete-floor-plan") {
      if (confirm("Are you sure you want to remove this floor plan?")) {
        axios
          .post(url, { id: id })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.getFloorPlans(
                  this.pagination.path + "?page=" + this.pagination.currentPage
                );
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while deleting floor plan.";
            this.notifType = "error";
            this.notifCounter++;
          });
      }
    },
    getSelectedFloorPlan(id) {
      this.selectedFloorPlan = this.floorPlans.find(element => { return element.id === id });
    },
    viewFloorPlanPreview(id) {
      console.log(this.getSelectedFloorPlan(id));
      this.showPreview = true;
    },
    closePreview() {
      this.showPreview = false;
    },
    updateFloorPlan(id, key, value, url = "/update-floor-plan") {
      if (value != this.previousValue) {
        axios
          .post(url, { id: id, key: key, value: value })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.getFloorPlans(
                  this.pagination.path + "?page=" + this.pagination.currentPage
                );
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while updating floor plan.";
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
    saveHouseImages() {
      this.houseImages = [];
      for (var i = 0; i < this.$refs.house_images.files.length; i++) {
        this.houseImages.push(this.$refs.house_images.files[i]);
      }
    },
    saveFloorPlanImages() {
      this.floorPlanImages = [];
      for (var i = 0; i < this.$refs.floor_plan_images.files.length; i++) {
        this.floorPlanImages.push(this.$refs.floor_plan_images.files[i]);
      }
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
        if (val == null || val == undefined || val == "") delete obj[key];
      });
    },
    clearFirstRow() {
      if (this.isSearching) {
        this.setSearchData();
        this.getFloorPlans();
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
        // this.autocadImageShow = false;
        // this.$nextTick(() => {
        //   this.autocadImageShow = true;
        // });

        this.houseImages = [];
        this.floorPlanImages = [];
      }
    },
    setSearchData() {
      this.tableData.search = {};
    },
    setInsertData() {
      this.insertData = {};
    },
    switchMode(value) {
      this.isSearching = value;
      // this.$refs.firstCell[0].focus();
      // this.$refs.firstCell[0].select();
    },
    houseImageUploadLabel() {
      let image = this.houseImages;
      return !image.length
        ? "Choose image"
        : image.length === 1
        ? image[0].name
        : image.length + " images selected";
    },
    floorPlanImageUploadLabel() {
      let image = this.floorPlanImages;
      return !image.length
        ? "Choose image"
        : image.length === 1
        ? image[0].name
        : image.length + " images selected";
    },
  },
};
</script>
