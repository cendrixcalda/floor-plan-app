<style lang="scss" scoped>
@import "@/_variables.scss";

.pagination-container {
  @include flexCenteredXY;
  white-space: nowrap;
  max-width: 100vw;
  margin: 15px 0;

  .pagination {
    display: flex;
    justify-content: flex-start;
    width: 90%;

    .page-stats, .page-row {
      align-items: center;
      padding: 5px;
      margin-right: 10px;
    }

    a {
      padding: 5px 10px;
      color: $terColor;
      cursor: default;

      &:hover:not(.disabled) {
        background: $secColor;
        cursor: pointer;
      }

      &.disabled {
        color: $lightGray;
      }
    }

    .pages {
      padding: 5px 10px;
      cursor: pointer;

      &:hover:not(.active) {
        background: $secColor;
      }

      &.active {
        background: $priColor;
        color: $secColor;
      }
    }
  }
}

@media (max-width: 470px) {
  .pagination-container {
    margin: 10px 0 20px;

    .pagination {
      flex-direction: column;
      align-items: center;

      .page-stats {
        margin-bottom: 7px;
      }
    }
  }
}
</style>

<template>
  <nav class="pagination-container">
    <div class="pagination">
      <span
        class="page-stats"
      >{{pagination.from ? pagination.from : 0}} - {{pagination.to ? pagination.to : 0}} of {{pagination.total}}</span>
      
      <div class="page-row">
        <a @click="$emit('prev');" v-if="pagination.prevPageUrl">Prev</a>
        <a class="disabled" v-else disabled>Prev</a>

        <span
          class="pages"
          :class="{ active: pagination.currentPage == index }"
          @click="$emit('index', index);"
          v-for="index in pageLinks"
          :key="index"
        >{{ index }}</span>

        <a @click="$emit('next');" v-if="pagination.nextPageUrl">Next</a>
        <a class="disabled" v-else disabled>Next</a>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  props: ["pagination"],
  data() {
    return {
      pageLinkLimit: 5,
    };
  },
  computed: {
    pageLinks: function () {
      if (this.pagination.lastPage <= this.pageLinkLimit) {
        return this.pagination.lastPage;
      } else if (
        Math.ceil(this.pagination.currentPage / this.pageLinkLimit) *
          this.pageLinkLimit >
        this.pagination.lastPage
      ) {
        let last =
          Math.ceil(this.pagination.currentPage / this.pageLinkLimit) *
          this.pageLinkLimit;
        let start = last - (this.pageLinkLimit - 1);
        last = this.pagination.lastPage;
        let pageLinks = [];
        for (start; start <= last; start++) {
          pageLinks.push(start);
        }
        return pageLinks;
      } else if (this.pagination.lastPage > this.pageLinkLimit) {
        let last =
          Math.ceil(this.pagination.currentPage / this.pageLinkLimit) *
          this.pageLinkLimit;
        let start = last - (this.pageLinkLimit - 1);
        let pageLinks = [];
        for (start; start <= last; start++) {
          pageLinks.push(start);
        }
        return pageLinks;
      }
    },
  },
};
</script>