import React from 'react'
import { FormEvent, useState } from "react"
import apiClient, { ErrorBag } from "../libs/api-client"
import ErrorMessage from './error-message'

interface Props {
  onSuccess: () => void
}

export default function NewUserForm({ onSuccess }: Props) { 
  const [nickname, setNickname] = useState<string>('')
  const [errors, setErrors] = useState<ErrorBag | null>(null)

  const createUser = async () => {
    await apiClient.post('/api/users', {
      nick_name: nickname.trim(),
    })

    localStorage.setItem('nickname', nickname.trim())
  }
  
  const handleNicknameChange = (value: string) => {
    const formattedValue = value.trim().toUpperCase()
    setNickname(formattedValue)

    setErrors(null)
  }

  const handleSignIn = async (e: FormEvent) => {
    e.preventDefault()

    try {
      await createUser()
      onSuccess()
    } catch (error) {
      if (error instanceof ErrorBag) {
        setErrors(error)
        return
      }

      console.error('Error signing in:', error) 
    }
  }
  
  return (
    <form onSubmit={handleSignIn} className='flex flex-col gap-2'>
      <div className='flex flex-row gap-4'>
        <label htmlFor="nickname" className="sr-only">Apelido</label>
        <input
          type="text"
          value={nickname}
          onChange={(e) => handleNicknameChange(e.target.value)}
          className="input grow placeholder:text-gray-500"
          placeholder="Digite seu apelido"
        />

        <button type="submit" className="btn btn-primary">Entrar</button>
      </div>
      
      {errors && <ErrorMessage errorBag={errors} />}

      {!errors && <p className='text-center text-sm text-gray-500'>Pra que senha? Só coloque um apelido!</p>}
    </form>
  );
}