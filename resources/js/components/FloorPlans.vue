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

    .tools-right {
      display: flex;

      & > * {
        margin: 0 5px;
      }

      .show-on-desktop {
        display: flex;
      }

      .show-on-mobile {
        display: none;
      }

      .edit {
        display: flex;
        border: 1px solid $lightGray;

        button {
          outline: none;
          border: none;
          margin: 0;
          padding: 5px 15px;
          background: $inactivePriColor;
          color: $secColor;

          i {
            padding: 5px 5px 5px 0 ;
          }

          &:hover {
            box-shadow: 0 0 8px $priColor;
          }

          &.active {
            background: $priColor;
            color: $secColor;
          }
        }
      }

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

          i {
            padding: 5px 5px 5px 0 ;
          }

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
}

.file-inputs {
  padding: 0px 5px !important;
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

  button, a {
    outline: none;
    border: none;
    background: transparent;
    padding: 7px;
    border-radius: 50%;
    font-size: 17px;
  }

  .preview {
    width: 100%;
    max-width: 900px;
    min-height: 90vh;
    overflow-y: auto;
    background: $secColor;
    padding: 30px 15px 10px;

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

          .preview-section-image-container, .preview-new-image {
            width: 400px;
            margin: 5px auto;
            position: relative;
            background: $shadowColor;

            .image-tools, .new-image-tools {
              position: absolute;
              top: 0;
              left: 0;
              display: none;
              justify-content: flex-end;
              width: 100%;
              padding: 10px;
              background: rgba(0, 0, 0, 0.3);

              button, a {
                color: $shadowColor;
                margin: 0 3px;

                &:hover,
                &:focus {
                  color: $priColor;
                  background: $shadowColor;
                }
              }
            }

            .new-image-tools {
              display: flex;
              justify-content: space-between;

              button {
                padding: 5px 10px;
                border-radius: 0;
              }
            }

            img {
              width: 100%;
              height: 250px;
            }

            .filename {
              width: 100%;
              height: 50px;
              padding: 15px 10px;
              white-space: nowrap;
              overflow: hidden !important;
              text-overflow: ellipsis !important;
              background: rgba(0, 0, 0, 0.1);
            }

            .add-file {
              @include flexCenteredY;
              width: 100%;
              height: 50px;
              padding: 0 10px;
              background: rgba(0, 0, 0, 0.1);

              .custom-file {
                margin-bottom: 6px;
              }

              button {
                color: $terColor;
                background: $shadowColor;
                margin-left: 10px;

                &.disabled {
                  color: $lightGray;
                }

                &:not(.disabled):hover,
                &:not(.disabled):focus {
                  color: $priColor;
                }
              }
            }

            .preview-no-new-image {
              @include flexCenteredXY;
              width: 100%;
              height: 250px;

              button {
                color: $terColor;
                background: $secColor;

                &:hover,
                &:focus {
                  color: $priColor;
                }
              }
            }

            .new-image-input {
                display: none;
            }
            
            &:hover .image-tools {
              display: flex;
            }

            &:hover .filename {
              background: rgb(126, 126, 126);
              color: $secColor !important;
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
    border-bottom: 2px solid $priColor;

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
  position: relative;
  top: 3px;

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

  .show-on-desktop {
    display: none !important;
  }

  .show-on-mobile {
    display: flex !important;
  }

  .edit {
    button {
      padding: 5px 20px !important;
      i {
        padding: 0 !important;
      }
    }
  }

  .mode {
    button {
      padding: 5px 20px !important;
      i {
        padding: 0 !important;
      }
    }
  }

  .preview-section-images {
    display: flex !important;
    flex-direction: column;

    .preview-section-image-container, .preview-new-image {
      width: 100% !important;
    }
  }
}

@media (max-width: 340px) {
  .preview-section-image-container, .preview-new-image {
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
        <div class="tools-right">
          <div class="mode" v-show="isEditing">
            <button
              title="Switch to search mode"
              :class="{ active: isSearching }"
              :disabled="isSearching"
              @click="switchMode(true), clearFirstRow()"
            >
            <span class="show-on-desktop"><i class="fas fa-search"></i>Search</span>
            <i class="fas fa-search show-on-mobile"></i>
            </button>
            <button
              title="Switch to insert mode"
              :class="{ active: !isSearching }"
              :disabled="!isSearching"
              @click="
                switchMode(false),
                  setSearchData(),
                  getFloorPlans(pagination.path + '?page=' + pagination.currentPage),
                  clearFirstRow()
              "
            >
              <span class="show-on-desktop"><i class="fas fa-plus"></i>Insert</span>
              <i class="fas fa-plus show-on-mobile"></i>
            </button>
          </div>
          <div class="edit">
            <button
              :title="editTooltip"
              :class="{ active: isEditing }"
              @click="toggleIsEditing()"
            >
              <span class="show-on-desktop"><i class="fas fa-pen"></i>{{ isEditing ? 'Editing enabled' : 'Editing disabled' }}</span>
              <i class="fas fa-pen show-on-mobile"></i>
            </button>
          </div>
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
              v-if="!sliderColumns.includes(column)"
              v-on="numberDotColumns.includes(column) ? { keypress: ($event) => numberDotOnly($event) } : {}"
            />
            <div class="per-level" v-if="column == 'area'"><vue-slider v-model="areaMinMax" :min="0" :max="areaMax" tooltipPlacement="bottom" @change="getFloorPlans(), tableData.search.area = areaMinMax"></vue-slider></div>
            <div class="per-level" v-if="column == 'length'"><vue-slider v-model="lengthMinMax" :min="0" :max="lengthMax" tooltipPlacement="bottom" @change="getFloorPlans(), tableData.search.length = lengthMinMax"></vue-slider></div>
            <div class="per-level" v-if="column == 'width'"><vue-slider v-model="widthMinMax" :min="0" :max="widthMax" tooltipPlacement="bottom" @change="getFloorPlans(), tableData.search.width = widthMinMax"></vue-slider></div>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>
            <button
              title="Clear all"
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
              v-if="!autocomputedColumns.includes(column)"
              v-on="numberDotColumns.includes(column) ? { keypress: ($event) => numberDotOnly($event) } : {}"
            />
            <div class="per-level" v-if="column == 'bedroom_per_level'">{{ numberFormat(bedroomPerLevel) }}</div>
            <div class="per-level" v-if="column == 'living_per_level'">{{ numberFormat(livingPerLevel) }}</div>
            <div class="per-level" v-if="column == 'bathroom_per_level'">{{ numberFormat(bathroomPerLevel) }}</div>
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
          <td class="file-inputs">
            <div class="custom-file">
              <input
                type="file"
                ref="files"
                class="custom-file-input"
                id="files"
                multiple
                v-if="fileShow"
                @change="saveFiles()"
              />
              <label class="custom-file-label" for="files">{{
               fileUploadLabel()
              }}</label>
            </div>
          </td>
          <td>
            <button title="Add new floor plan record" type="button" class="options" @click="insertFloorPlan()">
              <i class="fas fa-plus"></i>
            </button>
          </td>
          <td>
            <button
              title="Clear all"
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
              :readonly="!isEditing || autocomputedColumns.includes(key)"
              v-on="numberDotColumns.includes(key) ? { keypress: ($event) => numberDotOnly($event) } : {}"
            />
          </td>
          <td class="file-count-col">{{ floorPlan.house_image.length ? floorPlan.house_image.length + ' image/s' : 'No image' }}</td>
          <td class="file-count-col">{{ floorPlan.floor_plan_image.length ? floorPlan.floor_plan_image.length + ' image/s' : 'No image' }}</td>
          <td class="file-count-col">{{ floorPlan.file.length ? floorPlan.file.length + ' file/s' : 'No file' }}</td>
          <td>
            <button title="View images and files" type="button" class="options" @click="viewFloorPlanPreview(floorPlan.id)">
              <i class="fas fa-eye"></i>
            </button>
          </td>
          <td>
            <button
              title="Delete floor plan record"
              type="button"
              class="options"
              :disabled="!isEditing"
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
            <div class="preview-section-images" v-if="selectedFloorPlan.house_image.length">
              <div
                class="preview-section-image-container"
                v-for="(houseImage, index) in selectedFloorPlan.house_image"
                :key="index"
                >
                <div 
                  class="image-tools">
                  <a
                    class="fas fa-search-plus"
                    title="View in full size"
                    :href="'images/house_images/' + houseImage['title']"
                    target="_blank"
                  ></a>
                  <a
                    class="fas fa-arrow-alt-circle-down"
                    title="Download image"
                    :href="'images/house_images/' + houseImage['title']"
                    download
                  ></a>
                  <button
                    class="fas fa-trash"
                    title="Delete image"
                    @click="deleteHouseImage(houseImage.id, index)"
                    v-show="isEditing"
                  ></button>
                </div>
                <img :src="'images/house_images/' + houseImage['title']" />
              </div>
              <div class="preview-new-image" v-show="isEditing">
                <input
                  type="file"
                  :ref="'newHouseImage'"
                  class="custom-file-inputs new-image-input"
                  :id="'newHouseImage'"
                  accept="image/*"
                  v-if="!newHouseImagePreview"
                  @change="selectNewHouseImage()"
                />
                <div class="new-image-tools" v-if="newHouseImagePreview">
                  <button @click="insertNewHouseImage(selectedFloorPlan.id)">save</button>
                  <button @click="cancelNewHouseImage()">cancel</button>
                </div>
                <img :src="newHouseImagePreview" v-if="newHouseImagePreview"/>
                <div class="preview-no-new-image" v-else>
                  <button
                    class="fas fa-plus"
                    title="Add image"
                    @click="$refs.newHouseImage.click()"
                  ></button>
                </div>
              </div>
            </div>
            <div class="px-3" v-else>
              No image
            </div>
            <div class="preview-section-images" v-if="!selectedFloorPlan.house_image.length && isEditing">
              <div class="preview-new-image">
                <input
                  type="file"
                  :ref="'newHouseImage'"
                  class="custom-file-inputs new-image-input"
                  :id="'newHouseImage'"
                  accept="image/*"
                  v-if="!newHouseImagePreview"
                  @change="selectNewHouseImage()"
                />
                <div class="new-image-tools" v-if="newHouseImagePreview">
                  <button @click="insertNewHouseImage(selectedFloorPlan.id)">save</button>
                  <button @click="cancelNewHouseImage()">cancel</button>
                </div>
                <img :src="newHouseImagePreview" v-if="newHouseImagePreview"/>
                <div class="preview-no-new-image" v-else>
                  <button
                    class="fas fa-plus"
                    title="Add image"
                    @click="$refs.newHouseImage.click()"
                  ></button>
                </div>
              </div>
            </div>
          </div>

          <div class="preview-section">
            <div class="preview-section-title">
              Floor Plan Images
            </div>
            <div class="preview-section-images" v-if="selectedFloorPlan.floor_plan_image.length">
              <div
                class="preview-section-image-container"
                v-for="(floorPlanImage, index) in selectedFloorPlan.floor_plan_image"
                :key="index"
                >
                <div
                  class="image-tools">
                  <a
                    class="fas fa-search-plus"
                    title="View in full size"
                    :href="'images/floor_plan_images/' + floorPlanImage['title']"
                    target="_blank"
                  ></a>
                  <a
                    class="fas fa-arrow-alt-circle-down"
                    title="Download image"
                    :href="'images/floor_plan_images/' + floorPlanImage['title']"
                    download
                  ></a>
                  <button
                    class="fas fa-trash"
                    title="Delete image"
                    @click="deleteFloorPlanImage(floorPlanImage.id, index)"
                    v-show="isEditing"
                  ></button>
                </div>
                <img :src="'images/floor_plan_images/' + floorPlanImage['title']" />
              </div>
              <div class="preview-new-image" v-show="isEditing">
                <input
                  type="file"
                  :ref="'newFloorPlanImage'"
                  class="custom-file-inputs new-image-input"
                  :id="'newFloorPlanImage'"
                  accept="image/*"
                  v-if="!newFloorPlanImagePreview"
                  @change="selectNewFloorPlanImage()"
                />
                <div class="new-image-tools" v-if="newFloorPlanImagePreview">
                  <button @click="insertNewFloorPlanImage(selectedFloorPlan.id)">save</button>
                  <button @click="cancelNewFloorPlanImage()">cancel</button>
                </div>
                <img :src="newFloorPlanImagePreview" v-if="newFloorPlanImagePreview"/>
                <div class="preview-no-new-image" v-else>
                  <button
                    class="fas fa-plus"
                    title="Add image"
                    @click="$refs.newFloorPlanImage.click()"
                  ></button>
                </div>
              </div>
            </div>
            <div class="px-3" v-else>
              No image
            </div>
            <div class="preview-section-images" v-if="!selectedFloorPlan.floor_plan_image.length && isEditing">
              <div class="preview-new-image">
                <input
                  type="file"
                  :ref="'newFloorPlanImage'"
                  class="custom-file-inputs new-image-input"
                  :id="'newFloorPlanImage'"
                  accept="image/*"
                  v-if="!newFloorPlanImagePreview"
                  @change="selectNewFloorPlanImage()"
                />
                <div class="new-image-tools" v-if="newFloorPlanImagePreview">
                  <button @click="insertNewFloorPlanImage(selectedFloorPlan.id)">save</button>
                  <button @click="cancelNewFloorPlanImage()">cancel</button>
                </div>
                <img :src="newFloorPlanImagePreview" v-if="newFloorPlanImagePreview"/>
                <div class="preview-no-new-image" v-else>
                  <button
                    class="fas fa-plus"
                    title="Add image"
                    @click="$refs.newFloorPlanImage.click()"
                  ></button>
                </div>
              </div>
            </div>
          </div>

          <div class="preview-section">
            <div class="preview-section-title">
              Files
            </div>
            <div class="preview-section-images" v-if="selectedFloorPlan.file.length">
              <div
                class="preview-section-image-container"
                v-for="(file, index) in selectedFloorPlan.file"
                :key="index">
                  <div class="image-tools">
                    <a
                      class="fas fa-arrow-alt-circle-down"
                      title="Download file"
                      :href="'files/' + file['title']"
                      download
                    ></a>
                    <button
                      class="fas fa-trash"
                      title="Delete file"
                      @click="deleteNewFloorPlanFile(file.id, index)"
                      v-show="isEditing"
                    ></button>
                  </div>
                <div class="filename">{{ file['title'] }}</div>
              </div>
              <div class="preview-section-image-container" v-show="isEditing">
                <div class="add-file">
                  <div class="custom-file">
                    <input
                      type="file"
                      ref="filesOnEdit"
                      class="custom-file-input"
                      id="files-on-edit"
                      multiple
                      v-if="fileOnEditShow"
                      @change="saveFilesOnEdit()"
                    />
                    <label class="custom-file-label" for="files-on-edit">{{
                    fileOnEditUploadLabel()
                    }}</label>
                  </div>
                  <button
                    class="fas fa-plus"
                    :class="{ disabled: !filesOnEdit.length }"
                    title="Upload file"
                    @click="insertNewFloorPlanFile(selectedFloorPlan.id)"
                    :disabled="!filesOnEdit.length"
                  ></button>
                </div>
              </div>
            </div>
            <div class="px-3 mb-3" v-else>
              No file
            </div>
            <div class="preview-section-images" v-if="!selectedFloorPlan.file.length && isEditing">
              <div class="preview-section-image-container">
                <div class="add-file">
                  <div class="custom-file">
                    <input
                      type="file"
                      ref="filesOnEdit"
                      class="custom-file-input"
                      id="files-on-edit"
                      multiple
                      v-if="fileOnEditShow"
                      @change="saveFilesOnEdit()"
                    />
                    <label class="custom-file-label" for="files-on-edit">{{
                    fileOnEditUploadLabel()
                    }}</label>
                  </div>
                  <button
                    class="fas fa-plus"
                    :class="{ disabled: !filesOnEdit.length }"
                    title="Upload file"
                    @click="insertNewFloorPlanFile(selectedFloorPlan.id)"
                    :disabled="!filesOnEdit.length"
                  ></button>
                </div>
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
import VueSlider from 'vue-slider-component'

export default {
  components: {
    "notifications-overlay": NotificationsOverlay,
    datatable: Datatable,
    pagination: Pagination,
    "vue-slider": VueSlider,
  },
  data() {
    return {
      notifMessage: "",
      notifType: "",
      notifCounter: 0,
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
      files: [],
      filesOnEdit: [],
      excludedColumns: [
        "id", 
        "house_image", 
        "floor_plan_image", 
        "file",
        "created_at", 
        "updated_at", 
        "deleted_at"
      ],
      excludedFirstRowColumns: [
        "id",
        "house_images",
        "floor_plan_images",
        "files",
        "created_at",
        "updated_at",
        "deleted_at",
      ],
      numberDotColumns: [
        "number_of_levels", 
        "area", 
        "length", 
        "width",
        "bedroom_per_level", 
        "living_per_level", 
        "bathroom_per_level", 
        "carport_per_level",
        "bedroom_per_building", 
        "living_per_building", 
        "bathroom_per_building", 
        "carport_per_building",
      ],
      autocomputedColumns: [
        "bedroom_per_level", 
        "living_per_level", 
        "bathroom_per_level", 
      ],
      sliderColumns: [
        "area", 
        "length", 
        "width", 
      ],
      areaMax: 1,
      lengthMax: 1,
      widthMax: 1,
      areaMinMax: [0, 1],
      lengthMinMax: [0, 1],
      widthMinMax: [0, 1],
      firstFloorPlanCall: true,
      selectedFloorPlan: null,
      isSearching: true,
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
      editTooltip: "Click to enable editing",
      isEditing: false,
      houseImageShow: true,
      floorPlanImageShow: true,
      fileShow: true,
      fileOnEditShow: true,
      showPreview: false,
      newHouseImage: null,
      newFloorPlanImage: null,
      newHouseImagePreview: null,
      newFloorPlanImagePreview: null,
    };
  },
  mounted() {
    this.getFloorPlanColumns();
    let data = this.getFloorPlans();
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

            //format column numbers to be proper number
            this.floorPlans.forEach((floorPlan, floorKey) => {
              Object.entries(floorPlan).forEach(([key, val]) => {
                if(this.numberDotColumns.includes(key)){
                  this.floorPlans[floorKey][key] = this.numberComma(val);
                }
              });
            });

            //set slider max value on first call
            if(this.firstFloorPlanCall) {
              this.setSliderMaxValues();

              this.$nextTick(() => {
                this.areaMinMax = [0, this.areaMax];
                this.lengthMinMax = [0, this.lengthMax];
                this.widthMinMax = [0, this.widthMax];
              });

              this.firstFloorPlanCall = false;
            }
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
          //validations
          if(this.numberDotColumns.includes(key)){
            val = val === '' || val === null || val === undefined ? '0.00' : this.numberFormat(val);
          }

          formData.append("details[" + key + "]", JSON.stringify(val));
        });

        this.houseImages.forEach((image, index) => {
          formData.append("house_images[" + index + "]", image);
        });

        this.floorPlanImages.forEach((image, index) => {
          formData.append("floor_plan_images[" + index + "]", image);
        });

        this.files.forEach((file, index) => {
          formData.append("files[" + index + "]", file);
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
              this.setSliderMaxValues();
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
                this.setSliderMaxValues();
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
      this.showPreview = true;
      this.getSelectedFloorPlan(id);
    },
    closePreview() {
      this.showPreview = false;
      this.filesOnEdit = [];
    },
    updateFloorPlan(id, key, value, url = "/update-floor-plan") {
      value = value === '' ? null : value; 
      if (value != this.previousValue) {
        //validations
        if(this.numberDotColumns.includes(key)){
          value = value === '' || value === null || value === undefined ? '0.00' : this.numberFormat(value);
        }
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
                this.setSliderMaxValues();
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
    saveFiles() {
      this.files = [];
      for (var i = 0; i < this.$refs.files.files.length; i++) {
        this.files.push(this.$refs.files.files[i]);
      }
    },
    saveFilesOnEdit() {
      this.filesOnEdit = [];
      for (var i = 0; i < this.$refs.filesOnEdit.files.length; i++) {
        this.filesOnEdit.push(this.$refs.filesOnEdit.files[i]);
      }
    },
    deleteHouseImage(id, index, url = "/delete-house-image") {
      if (confirm("Are you sure you want to remove this house image?")) {
        axios
          .post(url, { id: id })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.selectedFloorPlan.house_image.splice(index, 1);
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while deleting house image.";
            this.notifType = "error";
            this.notifCounter++;
          });
      }
    },
    deleteFloorPlanImage(id, index, url = "/delete-floor-plan-image") {
      if (confirm("Are you sure you want to remove this floor plan image?")) {
        axios
          .post(url, { id: id })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.selectedFloorPlan.floor_plan_image.splice(index, 1);
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while deleting floor plan image.";
            this.notifType = "error";
            this.notifCounter++;
          });
      }
    },
    selectNewHouseImage() {
      let newImage = this.$refs.newHouseImage.files[0];
      this.newHouseImage = newImage;

      if (newImage) {
        var newPreview = URL.createObjectURL(newImage);

        this.newHouseImagePreview = newPreview;
      }
    },
    cancelNewHouseImage() {
      this.newHouseImage = null;
      this.newHouseImagePreview = null;
    },
    insertNewHouseImage(floorPlanId, url = "/insert-house-image") {
      let formData = new FormData();

      formData.append("newHouseImage", this.newHouseImage);
      formData.append("floorPlanId", floorPlanId);

      const config = {
        header: {
          "Content-Type": "multipart/form-data",
        },
      };

      axios
        .post(url, formData, config)
        .then(response => {
          let data = response.data;

          this.notifMessage = data.notifMessage;
          this.notifType = data.notifType;
          this.notifCounter++;

          if (data.notifType == "success") {
            let tempObj = {};
            tempObj["id"] = data.newHouseImageId;
            tempObj["title"] = data.newHouseImage;
            this.selectedFloorPlan.house_image.push(tempObj);
            this.cancelNewHouseImage();
          }
        })
        .catch(errors => {
          this.notifMessage = "Error encountered while inserting new house image.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    selectNewFloorPlanImage() {
      let newImage = this.$refs.newFloorPlanImage.files[0];
      this.newFloorPlanImage = newImage;

      if (newImage) {
        var newPreview = URL.createObjectURL(newImage);

        this.newFloorPlanImagePreview = newPreview;
      }
    },
    cancelNewFloorPlanImage() {
        this.newFloorPlanImage = null;
        this.newFloorPlanImagePreview = null;
    },
    insertNewFloorPlanImage(floorPlanId, url = "/insert-floor-plan-image") {
      let formData = new FormData();

      formData.append("newFloorPlanImage", this.newFloorPlanImage);
      formData.append("floorPlanId", floorPlanId);

      const config = {
        header: {
          "Content-Type": "multipart/form-data",
        },
      };

      axios
        .post(url, formData, config)
        .then(response => {
          let data = response.data;

          this.notifMessage = data.notifMessage;
          this.notifType = data.notifType;
          this.notifCounter++;

          if (data.notifType == "success") {
            let tempObj = {};
            tempObj["id"] = data.newFloorPlanImageId;
            tempObj["title"] = data.newFloorPlanImage;
            this.selectedFloorPlan.floor_plan_image.push(tempObj);
            this.cancelNewFloorPlanImage();
          }
        })
        .catch(errors => {
          this.notifMessage = "Error encountered while inserting new floor plan image.";
          this.notifType = "error";
          this.notifCounter++;
        });
    },
    deleteNewFloorPlanFile(id, index, url = "/delete-floor-plan-file") {
      if (confirm("Are you sure you want to remove this file?")) {
        axios
          .post(url, { id: id })
          .then((response) => {
            if (response) {
              this.notifMessage = response.data.notifMessage;
              this.notifType = response.data.notifType;
              this.notifCounter++;

              if (response.data.notifType == "success") {
                this.selectedFloorPlan.file.splice(index, 1);
              }
            }
          })
          .catch((errors) => {
            this.notifMessage =
              "Error encountered while deleting file.";
            this.notifType = "error";
            this.notifCounter++;
          });
      }
    },
    insertNewFloorPlanFile(id, url = "/insert-floor-plan-file") {
      let formData = new FormData();

      formData.append("id", id);

      this.filesOnEdit.forEach((file, index) => {
        formData.append("files[" + index + "]", file);
      });

      const config = {
        header: {
          "Content-Type": "multipart/form-data",
        },
      };

      axios
        .post(url, formData, config)
        .then((response) => {
          if (response) {
            let data = response.data;

            this.notifMessage = data.notifMessage;
            this.notifType = data.notifType;
            this.notifCounter++;

            if (data.notifType == "success") {
              data.newFiles.forEach((file, index) => {
                let tempObj = {};
                tempObj["id"] = data.newFilesId[index];
                tempObj["title"] = file;
                this.selectedFloorPlan.file.push(tempObj);
              });

              this.filesOnEdit = [];
            }
          }
        })
        .catch((errors) => {
          this.notifMessage = "Error encountered while inserting new file.";
          this.notifType = "error";
          this.notifCounter++;
        });
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
    setSearchData() {
      this.tableData.search = {};
      this.setSliderMaxValues();
      this.$nextTick(() => {
        this.areaMinMax = [0, this.areaMax];
        this.lengthMinMax = [0, this.lengthMax];
        this.widthMinMax = [0, this.widthMax];
      });
    },
    setInsertData() {
      this.insertData = {};
    },
    getMaxValueFromArrayOfObject(arr, key){ 
      var maxValue = 0; 
      for(var i = 0; i < arr.length; i++){
          var currentValue = arr[i][key] === null || arr[i][key] === '' || arr[i][key] === undefined ? 0 : arr[i][key];
          if(currentValue > maxValue){ 
            maxValue = currentValue;
          } 
      } 
      return maxValue; 
    },
    setSliderMaxValues() {
      let areaMax = this.getMaxValueFromArrayOfObject(this.floorPlans, 'area');
      let lengthMax = this.getMaxValueFromArrayOfObject(this.floorPlans, 'length');
      let widthMax = this.getMaxValueFromArrayOfObject(this.floorPlans, 'width');

      areaMax = parseInt(Math.ceil(areaMax/100)*100);
      lengthMax = parseInt(Math.ceil(lengthMax/100)*100);
      widthMax = parseInt(Math.ceil(widthMax/100)*100);

      this.areaMax = areaMax > this.areaMax ? areaMax : this.areaMax;
      this.lengthMax = lengthMax > this.lengthMax ? lengthMax : this.lengthMax;
      this.widthMax = widthMax > this.widthMax ? widthMax : this.widthMax;
    },
    toggleIsEditing() {
      this.isEditing = !this.isEditing;

      if(!this.isEditing) {
        this.switchMode(true);
        this.editTooltip = "Click to enable editing";
      } else {
        this.editTooltip = "Click to disable editing";
      }
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
    fileUploadLabel() {
      let file = this.files;
      return !file.length
        ? "Choose file"
        : file.length === 1
        ? file[0].name
        : file.length + " files selected";
    },
    fileOnEditUploadLabel() {
      let file = this.filesOnEdit;
      return !file.length
        ? "Choose file"
        : file.length === 1
        ? file[0].name
        : file.length + " files selected";
    },
    numberDotOnly(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
          evt.preventDefault()
      } else {
          return true
      }
    },
    numberFormat(value) {
      if(value) {
        //convert to string
        value = value.toString();

        //remove unnecessary strings except dots
        value = value.replace(/[^\d\.]/g, "")

        //return value with only one dot
        value = value.split('.');
        value = value.shift() + '.' + value.join('');
        
        //return 2 decimal places(rounded)
        value = parseFloat(Math.round(value * 100) / 100).toFixed(2);

        return value;
      }
    },
    numberComma(value) {
      if(value) {
        //number format, with commas evry thousand
        let formatter = new Intl.NumberFormat("en-US", {
          minimumFractionDigits: 2,
        });

        return formatter.format(value);
      }
    },
  },
  computed: {
    bedroomPerLevel: function (){
        let bedroomPerLevel = 0.00
        
        bedroomPerLevel += this.insertData.bed_1 ? 1.00 : 0.00;
        bedroomPerLevel += this.insertData.bed_2 ? 1.00 : 0.00;
        bedroomPerLevel += this.insertData.bed_3 ? 1.00 : 0.00;
        bedroomPerLevel += this.insertData.bedroom_4 ? 1.00 : 0.00;
        bedroomPerLevel += this.insertData.bedroom_5 ? 1.00 : 0.00;

        bedroomPerLevel = bedroomPerLevel > 0.00 ? bedroomPerLevel : '';
        
        if(bedroomPerLevel) this.insertData.bedroom_per_level = bedroomPerLevel;
        else delete this.insertData.bedroom_per_level;

        return bedroomPerLevel
    },
    livingPerLevel: function (){
        let livingPerLevel = 0.00
        
        livingPerLevel += this.insertData.living_1 ? 1.00 : 0.00;
        livingPerLevel += this.insertData.living_2 ? 1.00 : 0.00;
        livingPerLevel += this.insertData.living_3 ? 1.00 : 0.00;

        livingPerLevel = livingPerLevel > 0.00 ? livingPerLevel : '';

        if(livingPerLevel) this.insertData.living_per_level = livingPerLevel;
        else delete this.insertData.living_per_level;
        
        return livingPerLevel
    },
    bathroomPerLevel: function (){
        let bathroomPerLevel = 0.00
        
        bathroomPerLevel += this.insertData.bathroom_1 ? 1.00 : 0.00;
        bathroomPerLevel += this.insertData.bathroom_2 ? 1.00 : 0.00;
        bathroomPerLevel += this.insertData.bathroom_3 ? 1.00 : 0.00;
        bathroomPerLevel += this.insertData.bathroom_4 ? 1.00 : 0.00;
        bathroomPerLevel += this.insertData.bathroom_5 ? 1.00 : 0.00;

        bathroomPerLevel += this.insertData.guest_with_ensuite ? 1.00 : 0.00;
        bathroomPerLevel += this.insertData.ensuite ? 1.00 : 0.00;
        bathroomPerLevel += this.insertData.ensuite_2 ? 1.00 : 0.00;

        bathroomPerLevel += this.insertData.WC ? 0.50 : 0.00;
        bathroomPerLevel += this.insertData.WC_2 ? 0.50 : 0.00;

        bathroomPerLevel = bathroomPerLevel > 0.00 ? bathroomPerLevel : '';

        if(bathroomPerLevel) this.insertData.bathroom_per_level = bathroomPerLevel;
        else delete this.insertData.bathroom_per_level;
        
        return bathroomPerLevel
    },
  },
};
</script>
