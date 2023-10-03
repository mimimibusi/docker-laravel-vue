<template>
  <div id="overlay-modal" @click.stop="$emit('deleteModal')">
    <div class="base-modal">
      <div class="modal-header">
        <span id="close" class="btn btn-primary btn-link" @click.stop="$emit('deleteModal')">閉じる</span>
      </div>
      <div>
        <h1>{{ friendData.name }}</h1>
      </div>
      <div class="edit-content">
        <span v-if="existDMRoom" @click="startChat(friendData)">チャット</span>
        <span v-else @click="startChat(friendData)">チャットルーム作成</span>
        <span @click="joinChat(friendData)">グループ招待</span>
        <span id="delete" class="btn btn-primary btn-link" @click.stop="block()">ブロック</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import { User } from '../../@types/chat';
import { useRouter } from 'vue-router';

interface Props{
  friendData: User,
  modalFlag: boolean
}

export default({
  props:{
    friendData: {
      type: Object as ()=> User,
      required: true
    },
    existDMRoom: Boolean,
    modalFlag: Boolean
  },
  name: 'FriendModal',
  setup(props: Props){
    const router = useRouter();
    const block = ()=>{
      console.log('Blockしたよ');
    }

    const startChat = async (friendData: User)=>{
      const params = {
        friendId: friendData.id,
        roomName: friendData.name
      }
      await axios.post('/createChatRoom', params).then((res)=>{
        console.log(res.data);
        console.log('chatRoomが作れたはず');
        router.push('/chat')
      });
    }

    //ーーーーーー未開発ーーーーーー
    // const joinChat = async (friendData: User)=>{
    //   const params = {
    //     userId: friendData.id,
    //     roomId: 'hoge'
    //   }
    //   await axios.post('/joinChatRoom', params)
    // }
    return {
      block,
      startChat,
      joinChat
    }
  }
})
</script>

<style>
#overlay-modal{
  /*　要素を重ねた時の順番　*/
  z-index:2;

  /*　画面全体を覆う設定　*/
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background-color:rgba(0,0,0,0);

  /*　画面の中央に要素を表示させる設定　*/
  display: flex;
  align-items: center;
  justify-content: center;

}

.base-modal{
  position: relative;
  z-index: 3;
  padding: 20px;
  /* width: 33%;
  height: 33%;
  min-width: 350px; */
  background-color: white;
  box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.5);
}

.edit-content{
  display: flex;
  /* justify-content: space-between; */
  justify-content: flex-end;
  gap: 12px;
}

.edit-content #edit{
  text-decoration: none;
  color: black;
}
</style>