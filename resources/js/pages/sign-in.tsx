import React from 'react'
import MeteorsBackground from '../components/meteors-background'
import NewUserForm from '../components/new-user-form'

export default function SignIn() {
  return (
    <main className='relative w-screen h-screen overflow-hidden flex items-center justify-center p-4'>
      <MeteorsBackground />

      <div className='relative z-10 max-w-md w-full backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-8 shadow-xl'>
        <div className='flex flex-col items-center justify-center gap-4 mb-6'>
          <img src='/images/logo.svg' className='h-14' />
          <p className="text-center text-white">
            Bem-vindo ao <span className="font-bold">Phobos</span>, a plataforma dos viciados em séries — tipo academia, mas pra maratonar!
            <br />
            Digite seu apelido para começar.
          </p>
        </div>

        <NewUserForm />
      </div>
    </main>
  )
}
