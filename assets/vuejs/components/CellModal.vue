<script>

    export default {
        name: 'CellModal',
        props: {
            route: {
                type: String
            },
            x: {
                type: Number
            },
            y: {
                type: Number
            },

        },
        data () {
            return {
                modalHidden: true,
            }
        },
        methods: {
            toggleModal: function () {
                const body = document.querySelector('body');
                const modal = this.$el.querySelector('.modal');
                modal.classList.toggle('opacity-0');
                modal.classList.toggle('pointer-events-none');
                body.classList.toggle('modal-active');
            },
        }
    }
</script>



<template>
    <div>
        <div @click="toggleModal($event)" class="modal-open h-20 w-20">
        </div>

        <div @click="toggleModal($event)" class="modal opacity-0 fixed w-full h-full top-0 left-0 flex items-center pointer-events-none z-40">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50 top-0 left-0"></div>
            <div class="pb-4 right-0 modal-container  ml-12 rounded-lg shadow-lg z-50" style="height: 0; width: 0; background-color: #e7e9ee;">
                <div class="modal-content h-full pt-4 text-left">
                    <iframe class="w-full h-full" :src="this.route + '?x=' + this.x + '&y=' + this.y"></iframe>
                </div>
            </div>
        </div>
    </div>
</template>



<style>
    .modal {
        transition: opacity 0.25s ease;
    }
    div.modal-active {
        overflow-x: hidden;
        overflow-y: visible !important;
    }
    .modal-active .modal-container {
        height: 24rem !important;
        width: 28rem !important;
    }

</style>




