<template>
    <div class="start-page">
        <div class="start__img">

<!--            <button @click="$router.push(`/list/${getLists()[0].external_id}`)">Войти в приложение</button>-->
        </div>
    </div>
</template>

<script>
    import {mapGetters, mapMutations} from 'vuex'
    import {v4 as uuidv4} from "uuid";

    export default {
        name: "StartPage.vue",

        async mounted() {
            if(!this.$auth.check()) {
                this.setCurrentUserFalse()
            }
            if(!this.getLists().length) {

                await this.setFirstList()
                const listId = await this.getList()
                const products = [
                        {external_id: uuidv4(), title: 'Булочки с повидлом', 'list_id': listId, product_group_id: 'cb2eaa85-9232-4c25-b3ba-9472317ce28a', unit: '4 шт.', marked: false, product_group: {color: '#61F2CF'}, type: 'noAuth'},
                        {external_id: uuidv4(), title: 'Молоко', 'list_id': listId, product_group_id: '692b46bd-bdbc-4841-ae50-c8e85ea36f64', unit: '2 л.', marked: false, product_group: {color: '#AFEF98'}, type: 'noAuth'},
                        {external_id: uuidv4(), title: 'Хлеб Бородинский', 'list_id': listId, product_group_id: 'cb2eaa85-9232-4c25-b3ba-9472317ce28a', unit: '1 шт.', marked: true, product_group: {color: '#61F2CF'}, type: 'noAuth'},
                        {external_id: uuidv4(), title: 'Огурцы', 'list_id': listId, product_group_id: '5133b9e0-f27b-4b07-964c-00d2babaafb7', unit: '500 гр.', marked: false, product_group: {color: '#EC89E8'}, type: 'noAuth'},
                        {external_id: uuidv4(), title: 'Кефир', 'list_id': listId, product_group_id: '692b46bd-bdbc-4841-ae50-c8e85ea36f64', unit: '1 л.', marked: true, product_group: {color: '#AFEF98'}, type: 'noAuth'},
                        {external_id: uuidv4(), title: 'Шоколад "Аленка"', 'list_id': listId, product_group_id: '', unit: '1 шт.', marked: false, product_group: {color: ''}, type: 'noAuth'}
                    ]

                await this.setFirstProducts(products)
            } else {
                let fetchingData = await this.$auth.user()
                if(fetchingData) {
                    await this.setCurrentUser(fetchingData.user)
                    await this.setLists(fetchingData.list)
                    // await this.setProducts(fetchingData.product)
                }
            }

            let firstList =  await this.getLists()
            setTimeout(() => {
                this.$router.push(`/list/${firstList[0].external_id}`)
            }, 300)

        },
        methods: {
            ...mapGetters(['getLists', 'getList']),
            ...mapMutations(['setCurrentUser', 'setCurrentUserFalse', 'setFirstList', 'setFirstProducts', 'setLists', 'setProducts'])
        },
    }
</script>

<style scoped>
    .start-page {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: white;
    }
    .start__img {
        width: 100px;
        height: 100px;
        padding: 20px;
        border-radius: 100%;
        background-color: #EEEEEE;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .start__img img{
        width: 60px;
        height: 60px;
    }
</style>
