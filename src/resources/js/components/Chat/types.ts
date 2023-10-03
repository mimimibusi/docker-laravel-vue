export interface User{
  id: number,
  name: string
}

export interface ChatRoom{
  id: number,
  roomName: string
}

export interface ChatData{
  userId: number,
  message: string,
  date: string,
}