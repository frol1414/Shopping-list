<template>
<div class="share-form">

    <div class="attach-cards" @click="$router.push('/attach-cards')">
        <img :src="'../images/attach-cards.svg'" class="attach-cards__img" alt="attach-cards">
        <p class="attach-cards__title">Прикрепить карты (3)</p>
    </div>

    <form class="share__link">
        <input class="share__link-input" ref="link" :value="url" :disabled="!$auth.check()">
        <span class="share__copy" @click="copyLink"><img :src="'../images/copy.svg'" alt="copy"></span>
    </form>

    <p class="socials-title">Отправить ссылку</p>

    <div class="socials">
        <a :href="'https://telegram.me/share/url?url=' + url" target="_blank" :class="{isDisabled: !$auth.check()}">
            <img :src="'../images/telegram.svg'" alt="telegram">
        </a>
        <a :href="'https://wa.me/?text=' + url" target="_blank" :class="{isDisabled: !$auth.check()}">
            <img :src="'../images/watsapp.svg'" alt="watsapp">
        </a>
        <a :href="'https://vk.com/share.php?url=' + url" target="_blank" :class="{isDisabled: !$auth.check()}">
            <img :src="'../images/vk.svg'" alt="vk">
        </a>
        <a :href="'viber://forward?text=' + url" target="_blank" :class="{isDisabled: !$auth.check()}">
            <img :src="'../images/viber.svg'" alt="viber">
        </a>
    </div>
</div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "ShareForm.vue",
        data: function () {
            return {
                url: 'https://списокпокупок.рф/list/' + this.getCurrentList(),
            }
        },
        // async mounted() {
        //     this.selected = await this.$store.dispatch('getProductByList', this.getCurrentList())
        // },
        methods:{
            ...mapGetters(['getCurrentList']),
            copyLink() {
                let a = this.$refs.link;
                a.select()
                document.execCommand("copy");
            },
        },
    }
</script>
<style scoped>
    input {
        outline: none;
    }
    input:focus {
        outline: none;
    }
    .share__link {
        position: relative;
    }
    .attach-cards {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 30px auto;
    }
    .attach-cards__img {
        margin-right: 5px;
    }
    .attach-cards__title {
        font-weight: 500;
        font-size: 18px;
        line-height: 21px;
        color: #052137;
    }
    .share__link {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .share__link-input {
        width: 75%;
        border-radius: 10px;
        box-sizing: border-box;
        height: 40px;
        font-weight: normal;
        font-size: 15px;
        line-height: 17px;
        color: #052137;
        padding: 12px 13px;
        margin-right: 20px;
        background: #ffffff;
        border: none;
    }
    .share__copy {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 38px;
        background: transparent;
        cursor: pointer;

    }
    .socials-title {
        text-align: center;
        font-weight: normal;
        font-size: 14px;
        line-height: 16px;
        color: #7D7D7D;
        margin: 9px 0 5px 0;
    }
    .socials {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
    }
    .socials a {
        margin: 0 12px;
        cursor: pointer;
    }
    .isDisabled {
        pointer-events: none;
    }
</style>
