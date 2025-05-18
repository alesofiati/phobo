import React from 'react'
import { RoomSchema } from "../schemas/room";

interface Props {
  room: RoomSchema;
}

export default function RoomCard({ room }: Props) { 
  return (
    <div className='card bg-white shadow-xl p-4 gap-4'>
      <p className="text-center text-slate-500 text-sm">Nós estamos maratonando</p>

      <div className="flex flex-col gap-2">
        <p className="text-center text-slate-500 text-lg">{room.name}</p>

        {room.file_url && <img
          src={room.file_url}
          alt='Image cover'
          className='h-24 w-full object-cover'
        />}
      </div>
    </div>
  )
}