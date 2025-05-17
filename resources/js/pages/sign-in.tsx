import React from 'react'

export default function SignIn() {
  return (
  <main className='w-screen h-screen flex flex-row items-center justify-center gap-4'>
    <input type="text" className="input" placeholder="index.php" />

    <a className="btn btn-primary" href='/room/1'>Sign in</a>
  </main>
  )
}