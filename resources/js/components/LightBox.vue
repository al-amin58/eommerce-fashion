<template>
    <div>
        <div v-if="displayModal" class="light-box-overlay"></div>

        <div>
            <div class="d-flex align-items-center justify-content-center" @click.stop="displayModal = true">
                <img :src="image" @click.stop="displayModal = true"/>
            </div>
            <div class="d-flex align-items-center">
                <div v-for="(img, i) in images" class="d-flex align-items-center justify-content-center smallImageBorder" :key="`image-${i}`" @click.stop="displayModal = true">
                    <img :src="img" alt="" @click.stop="displayModal = true">
                </div>
            </div>
        </div>

        <div class="imageModal" id="modal" v-if="displayModal">
            <button @click="displayModal = false" class="position-absolute closeModal">
                <vue-feather type="x"/>
            </button>
            <div class="laight_box_carousel">
                <button class="prev" @click="prev">
                    <vue-feather type="chevron-left"/>
                </button>
                <img :src="image" />
                <button class="next" @click="next">
                    <vue-feather type="chevron-right"/>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "App",
    props:['images'],
    data() {
        return {
            index: 0,
            image: this.images[0],
            displayModal: false
        };
    },
    methods: {
        next() {
            this.index = (this.index + 1) % this.images.length;
            this.image = this.images[this.index];
        },
        prev() {
            this.index = (this.index - 1 + this.images.length) % this.images.length;
            this.image = this.images[this.index];
        },
        onClickOutsode(e) {
            console.log(e.target.localName)
            // if (e.target.localName !== "button") {
            //
            //     this.displayModal = false;
            // }

            if (!e.target.closest(".imageModal")) {
                this.displayModal = false;

                // menu.classList.add("is-hidden");
                // navigation.classList.remove("is-expanded");
            }


        },
    },
    mounted() {
        window.addEventListener("click", this.onClickOutsode);
    },










};
</script>
<style scoped>
img {
    width: 80%;
    height: auto;
}
#modal {
    position: absolute;
    top: 20px;
    width: 100%;
    left: 0;
    border: 1px solid gray;
    background-color: white;
}
.light-box-overlay{
    width: 100%;
    height: 100vh;
    background: #000000ad;
    position: fixed;
    top: 0;
    right: 0;
}
.laight_box_carousel{
    display: flex;
    align-items: center;
    justify-content: space-around;
}

.next,
.prev{
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    background: #03070ba8;
    color: white;
}

.closeModal{
    right: 5px;
    border: none;
    background: none;
    top: 6px;
    color: #000000b0;
}
.smallImageBorder{
    border:1px solid gray;
    border-right: 0;
}

.smallImageBorder:last-child{
    border-right:1px solid gray;
}

</style>
