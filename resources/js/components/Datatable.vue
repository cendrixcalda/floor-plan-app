<style lang="scss" scoped>
@import "@/_variables.scss";

main {
  @include flexCenteredXY;
  max-width: 100vw;

  .table-wrapper {
    position: relative;
    overflow: auto;
    max-width: 90%;
    height: 65vh;
    background: $secColor;
    border-radius: 3px;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);

    table {
      border-collapse: collapse;
      font-size: 15px;
      background: $secColor;

      tr {
        th,
        td {
          white-space: nowrap;
          min-width: 130px;
          padding: 10px 15px;
          border: 1px solid $lightGray;
          &:nth-last-child(1),
          &:nth-last-child(2) {
            min-width: 70px;
            text-align: center;
          }

          button {
            padding: 2px;
            border: none;
            background: transparent;
          }
        }

        th {
          text-align: left;
          background: $priColor;
          color: $secColor;
          position: sticky;
          top: -1px;
          z-index: 2;

          &.long-width {
            min-width: 250px;
          }

          &.striped {
            background: $priStripedColor;
          }
        }

        td {
          outline: none;
          padding: 0;

          input, .per-level {
            outline: none;
            border: none;
            margin: 0;
            padding: 11px 15px;
            width: 100%;

            &:hover,
            &:focus {
              outline: none;
              background: $shadowColor;
            }
          }

          input[type="file"] {
            padding: 8px 15px;
          }

          &:hover {
            outline: none;
            background: $shadowColor;
          }
        }

        .no-data {
          width: 100%;
          margin: 10px;
          border: none;
        }
      }
    }
  }
}
</style>

<template>
  <main>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th
              :class="{ 'long-width': longWidthColumns.includes(column), 'striped': stripedColumns.includes(column) }"
              v-for="column in columns"
              :key="column"
            >
              {{ column | capitalized }}
            </th>
            <th class="long-width striped" >{{ 'house_images' | capitalized }}</th>
            <th class="long-width striped" >{{ 'floor_plan_images' | capitalized }}</th>
            <th class="long-width striped" >{{ 'files' | capitalized }}</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <slot></slot>
      </table>
    </div>
  </main>
</template>

<script>
export default {
  props: {
    columns: {},
  },
  data() {
    return {
      longWidthColumns: ["area", "length", "width", "remarks", "house_images", "floor_plan_images", "files", "house_name"],
      stripedColumns: [
        'tracking_id',
        'bathroom_2',
        'bathroom_3',
        'bathroom_4',
        'bathroom_5',
        'WC_2',
        'deck_1',
        'deck_2',
        'bedroom_4',
        'bedroom_5',
        'WIR_2',
        'WIR_3',
        'WIR_4',
        'stairs_2',
        'stairs_3',
        'living_3',
        'kitchen_2',
        'hallway_3',
        'hallway_4',
        'hallway_5',
        'ensuite_2',
        'storage_3',
        'storage_4',
        'pool',
        'spa',
        'courtyard',
        'bedroom_per_level',
        'living_per_level',
        'bathroom_per_level',
        'carport_per_level',
        'shape',
        'house_images',
        'floor_plan_images',
        'files',
        ],
    };
  },
  filters: {
    capitalized: function (value) {
      let formattedValue = value.replace(/_/g, " ");

      formattedValue = formattedValue.split(" ");

      for (let i = 0; i < formattedValue.length; i++) {
        formattedValue[i] =
          formattedValue[i][0].toUpperCase() + formattedValue[i].substr(1);
      }

      return formattedValue.join(" ");
    },
  },
};
</script>
