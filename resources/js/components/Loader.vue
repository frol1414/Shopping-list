<template>
    <div class="loader">
        <h5 class="text-center">{{titles[Math.floor(Math.random() * titles.length)]}}</h5>
        <div class="loadingio-spinner-rolling-k68u7jjc8fl">
            <div class="ldio-uwjisvy6lgo">
            <div></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Loader.vue",
        data() {
            return {
                titles: [
                    'Ждем соединение со спутником...',
                    'Считаем зайчиков в лесу...',
                    'Ждем помощи Илона Маска...',
                    'Ждем создание квантового компьютера...',
                    'Летят как-то в одном самолете русский, немец и еврей...',
                    'Прячем заначку от жены...',
                    'I\'ll be back...',
                    'Ждем выхода Half-Life 3...',
                    'Пароль Пентагона - 123456',
                    'Лада веста спорт - Агонь!',
                    'Опять жена отправила за покупками?',
                ]
            }
        }
    }
</script>

<style scoped>
    .loader {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 120px;
        padding: 30px;
        animation: opacity .2s;
    }
    @keyframes ldio-uwjisvy6lgo {
        0% { transform: translate(-50%,-50%) rotate(0deg); }
        100% { transform: translate(-50%,-50%) rotate(360deg); }
    }
    .ldio-uwjisvy6lgo div {
        position: absolute;
        width: 50px;
        height: 50px;
        border: 5px solid #0a0a0a;
        border-top-color: transparent;
        border-radius: 50%;
    }
    .ldio-uwjisvy6lgo div {
        animation: ldio-uwjisvy6lgo 1.5s linear infinite;
        top: 50px;
        left: 100px
    }
    .loadingio-spinner-rolling-k68u7jjc8fl {
        width: 200px;
        height: 200px;
        display: inline-block;
        overflow: hidden;
    }
    .ldio-uwjisvy6lgo {
        width: 100%;
        height: 100%;
        position: relative;
        transform: translateZ(0) scale(1);
        backface-visibility: hidden;
        transform-origin: 0 0;
    }
    .ldio-uwjisvy6lgo div { box-sizing: content-box; }
</style>
