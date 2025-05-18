import React from 'react'
import { FormEvent, useState } from "react"
import apiClient, { ErrorBag } from "../libs/api-client"
import ImagePicker from './image-picker'
import ErrorMessage from './error-message'

interface Props {
  onSuccess: () => void
}

export default function NewRoomForm({ onSuccess }: Props) { 
  const [name, setNickname] = useState<string>('')
  const [imageFile, setImageFile] = useState<File | null>(null)

  const [errors, setErrors] = useState<ErrorBag | null>(null)

  const createRoom = async () => {
    const formData = new FormData();
    formData.append('name', name.trim());

    if (localStorage.getItem('nickname')) {
       formData.append('nick_name', localStorage.getItem('nickname')!);
    }
    
    if (imageFile) {
      formData.append('file', imageFile);
    }

    await apiClient.post('/api/rooms', formData);
  }
  
  const handleNameChange = (value: string) => {
    setNickname(value)
    setErrors(null)
  }

  const handleSignIn = async (e: FormEvent) => {
    e.preventDefault()

    try {
      await createRoom()
      onSuccess()
    } catch (error) {
      if (error instanceof ErrorBag) {
        setErrors(error)
        return
      }

      console.error('Error creating room:', error) 
    }
  }
  
  return (
    <form onSubmit={handleSignIn} className='flex flex-col gap-4'>
      <div className='flex flex-col gap-2'>
        <div className='flex flex-col gap-1'>
          <label htmlFor="image" className='text-sm text-gray-300'>Capa (opcional)</label>
          <ImagePicker 
            onLoadImage={setImageFile}      
          />
        </div>

        <div className='flex flex-col gap-1'>
          <label htmlFor="name" className='text-sm text-gray-300'>Nome da série</label>
          <input
            type="text"
            value={name}
            onChange={(e) => handleNameChange(e.target.value)}
            className="input grow w-full placeholder:text-gray-500"
            placeholder="Digite o nome qual da série ou anime"
          />
        </div>
      </div>

      <button type="submit" className="btn btn-primary">Vamos maratonar!</button>

      {errors && <ErrorMessage errorBag={errors} />}

      {!errors && <p className='text-center text-sm text-gray-500'>A capa não é obrigatória mas vou querer o nome, hein</p>}
    </form>
  );
}