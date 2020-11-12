<template>
    <div class="scanner-container">
        <div v-show="!isLoading">
            <video poster="data:image/gif,AAAA" ref="scanner"></video>

            <div class="active-camera">
                <img :src="'../images/scan.svg'" alt="scan">
                <p class="instructions__title">Наведите камеру на штрих-код</p>
            </div>

            <div class="scanner-instructions">
                <p class="instructions__title">Какая-то инструкция</p>
            </div>
<!--            <div class="overlay-element"></div>-->
<!--            <div class="laser"></div>-->
        </div>
        <div v-show="isLoading" class="NoActiveCamera">
            <img :src="'../images/scan.svg'" alt="scan">
            <p class="instructions__title">Наведите камеру на штрих-код</p>
        </div>
    </div>
</template>

<script>
    import { BrowserMultiFormatReader, Exception } from "@zxing/library";
    export default {
        name: "stream-barcode-reader",
        data() {
            return {
                isLoading: true,
                codeReader: new BrowserMultiFormatReader(),
                isMediaStreamAPISupported:
                    navigator &&
                    navigator.mediaDevices &&
                    "enumerateDevices" in navigator.mediaDevices

            };
        },
        mounted() {
            if (!this.isMediaStreamAPISupported) {
                throw new Exception("Media Stream API is not supported");
                return;
            }
            this.start();
            this.$refs.scanner.oncanplay = event => {
                this.isLoading = false;
                this.$emit("loaded");
            };
        },
        beforeDestroy() {
            this.codeReader.reset();
        },
        methods: {
            start() {
                this.codeReader.decodeFromVideoDevice(
                    undefined,
                    this.$refs.scanner,
                    (result, err) => {
                        if (result) {
                            this.$emit("decode", result.text);
                        }
                    }
                );
            }
        }
    };
</script>

<style scoped>
    video {
        max-width: 100%;
        width: 100%;
        /*max-height: 100%;*/
        /*height: 100%;*/
        position: absolute;
        transform: translateY(-20%);
        z-index: -1;
        background: black;
    }
    .scanner-container {
        position: relative;
        /*height: 100vh;*/
    }
    .scanner-instructions {
        background: black;
        width: 100%;
        height: 40vh;
        position: fixed;
        bottom: 0;
        right: 0;
        left: 0;
    }
    .instructions__title {
        font-weight: 500;
        font-size: 14px;
        line-height: 16px;
        background: transparent;
        color: #FFFFFF;
        text-align: center;
    }
    .NoActiveCamera {
        height: 100vh;
        background: black;
    }
    .active-camera {

    }
    .overlay-element {
        position: absolute;
        top: 0;
        width: 100%;
        height: 99%;
    }
    @-webkit-keyframes scanning {
        50% {
            -webkit-transform: translateY(100px);
            transform: translateY(100px);
        }
    }
    @keyframes scanning {
        50% {
            -webkit-transform: translateY(100px);
            transform: translateY(100px);
        }
    }
</style>
