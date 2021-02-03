<template>
  <div>
    <myHeader></myHeader>
    <!--    todoListコンポーネントはmain.jsでグローバル登録している-->
    <todoList></todoList>
    <myFooter></myFooter>
  </div>
</template>

<script>
import myHeader from './components/myheader.vue'
import myFooter from './components/myfooter.vue'

// コンポーネントをローカル登録する
export default {
  components: {
    myHeader: myHeader,
    myFooter: myFooter,
  }

}
</script>