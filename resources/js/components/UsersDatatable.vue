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

          &.medium-width {
            min-width: 150px;
          }

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

          .custom-checkbox {
            padding: 11px 15px 11px 40px;
            width: 100%;
            @include flexCenteredY();

            input[type="checkbox"] {
              height: 100% !important;
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
              :class="{ 'medium-width': mediumWidthColumns.includes(column), 'long-width': longWidthColumns.includes(column) }"
              v-for="column in columns"
              :key="column"
            >
              {{ column == 'plain_password' ? 'password' : column | capitalized }}
            </th>
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
      longWidthColumns: ["username", "plain_password"],
      mediumWidthColumns: ["user_type"],
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
