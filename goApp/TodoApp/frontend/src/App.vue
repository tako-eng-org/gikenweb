<template>
  <div>
    <myHeader></myHeader>
    <todoList></todoList>
    <myFooter></myFooter>
  </div>
</template>

<script>
import myHeader from './components/myheader.vue'
import todoList from './components/todolist.vue'
import myFooter from './components/myfooter.vue'

// コンポーネントをローカル登録する
export default {
  components: {
    myHeader: myHeader,
    todoList: todoList,
    myFooter: myFooter,
  }

}
</script>