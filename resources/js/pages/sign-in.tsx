import React from 'react'
import MeteorsBackground from '../components/meteors-background'
import NewUserForm from '../components/new-user-form'
import NewRoomForm from '../components/new-room-form'

export default function SignIn() {
  const [step, setStep] = React.useState(0)

  const handleOnSignInSuccess = () => {
    setStep(1)
  }

  const handleOnRoomCreated = () => {
    window.location.href = '/sala/' + localStorage.getItem('room_id')
  }

  return (
    <main className="relative w-screen min-h-screen flex items-center justify-center p-4">
      <MeteorsBackground />

      <div className="relative z-10 w-full max-w-md sm:max-w-lg md:max-w-xl backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl p-4 sm:p-6 md:p-8 shadow-xl">
        <div className="flex flex-col items-center justify-center gap-4 mb-6">
          <img src="/images/logo.svg" className="h-14" alt="Phobos Logo" />
          <p className="text-center text-white text-sm sm:text-base">
            Bem-vindo ao <span className="font-bold">Phobos</span>, a plataforma dos viciados em séries — tipo academia, mas pra maratonar!
          </p>
        </div>

        {step === 0 && <NewUserForm onSuccess={handleOnSignInSuccess}/>}
        {step === 1 && <NewRoomForm onSuccess={handleOnRoomCreated}/>}
      </div>
    </main>
  )
}
