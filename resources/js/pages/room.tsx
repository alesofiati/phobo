import React from 'react'
import { IconCamera } from '@tabler/icons-react'

export default function Home() {
  return (
    <div className='w-screen h-screen flex flex-col'>
      <div className="navbar bg-base-300 shadow-sm justify-center">
        <a className="text-xl" href='/'>Phomos</a>
      </div>

      <main className="w-full md:max-w-4xl mx-auto flex flex-row gap-8 h-full p-4">
        <div className='hidden w-96 gap-6 md:flex flex-col'>
          <div className='card h-72 bg-red-400 shadow-xl'/>
          <div className='card h-40 bg-red-400 shadow-xl'/> 

          <div className='btn h-12 btn-primary rounded-lg shadow-xl'> 
            New Activity
          </div>
        </div>

        <div className='flex flex-col gap-6 w-full'>
          <div className='md:hidden w-full gap-6 flex flex-col'>
            <div className='card h-72 bg-red-400 shadow-xl'/>
            <div className='card h-40 bg-red-400 shadow-xl'/> 
          </div>

          <p className='block text-xl md:text-2xl font-bold'>
            Activities
          </p>
          
          <div className='card w-full h-96 bg-base-300 shadow-xl'/>
          <div className='card w-full h-32 bg-red-400 shadow-xl'/>
          <div className='card w-full h-96 bg-base-300 shadow-xl'/>
        </div>

        <div className='md:hidden fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 gap-4 flex flex-row'>
          <button className='btn btn-primary rounded-full shadow-xl px-6'>
            New Activity
          </button>

          <button className='btn btn-primary rounded-full shadow-xl w-10 h-10 p-0 flex items-center justify-center'>
            <IconCamera className='w-6 h-6' />
          </button>
        </div>

      </main>
    </div>
  )
}