import React from 'react'
import { IconShare } from '@tabler/icons-react'
import { Activity } from '../schemas/activity'
import { AnimatePresence } from 'framer-motion'
import confetti from 'canvas-confetti'
import ActivityCard from '../components/activity-card'

export default function Home() {
  const [activities, setActivities] = React.useState<Activity[]>([
    {
      id: 1,
      description: 'This is a short activity',
      nickname: 'Felpera',
      rating: 5,
      episode: 1,
      season: 1,
      created_at: new Date(),
    },
    {
      id: 2,
      description: 'This is a very long activity. This have a lot of text. This is a very long activity. This have a lot of text. This is a very long activity. This have a lot of text. This is a very long activity. This have a lot of text.',
      nickname: 'Felpera',
      rating: 1,
      episode: 1,
      season: 1,
      created_at: new Date(),
    },
    {
      id: 3,
      description: 'This is a very long activity with image. This have a lot of text. This is a very long activity. This have a lot of text. This is a very long activity. This have a lot of text. This is a very long activity. This have a lot of text.',
      nickname: 'Felpera',
      image: "https://images.unsplash.com/photo-1584905066893-7d5c142ba4e1?q=80&w=2487&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
      rating: 3,
      episode: 1,
      season: 1,
      created_at: new Date(),
    }
  ])
  const buttonRef = React.useRef<HTMLButtonElement>(null)


  const showButtonConfetti = () => { 
    const rect = buttonRef.current?.getBoundingClientRect()
    if (!rect) return

    confetti({
      particleCount: 100,
      spread: 70,
      origin: {
        x: rect.left / window.innerWidth + rect.width / window.innerWidth / 2,
        y: rect.top / window.innerHeight + rect.height / window.innerHeight / 2,
      },
    })
  }

  const handleNewActivity = () => { 
    showButtonConfetti()

    setActivities(activities => [
      {
        id: Math.random(),
        description: 'This is a new activity',
        nickname: 'Felpera',
        rating: 5,
        episode: 1,
        season: 1,
      },
      ...activities
    ]);
  }

  return (
    <div className='w-screen min-h-screen flex flex-col'>
      <div className="navbar fixed top-0 left-0 right-0 z-50 bg-base-300 shadow-sm justify-center">
        <img src='/images/logo.svg' className='h-10'/>
      </div>

      <main className="w-full md:max-w-4xl mx-auto flex flex-row gap-8 h-full p-4 pt-24">
        <div className='hidden md:flex flex-col w-96 gap-6 sticky top-24 self-start h-fit z-10'>
          <div className='card h-72 bg-red-400 shadow-xl'/>
          <div className='card h-40 bg-red-400 shadow-xl'/>
          
          <button ref={buttonRef} onClick={handleNewActivity} className='btn h-12 btn-primary rounded-lg shadow-xl'>
            New Activity
          </button>

          <button className='btn h-12 rounded-lg shadow-xl'>
            Share
          </button>
        </div>

        <div className='flex flex-col gap-6 w-full'>
          <div className='md:hidden w-full gap-6 flex flex-col'>
            <div className='card h-72 bg-red-400 shadow-xl'/>
            <div className='card h-40 bg-red-400 shadow-xl'/> 
          </div>

          <p className='block text-xl md:text-2xl font-bold'>
            Activities
          </p>

          <AnimatePresence>
            {
              activities.map((activity) => (
                <ActivityCard 
                  key={activity.id}
                  activity={activity} 
                />
              ))
            }
          </AnimatePresence>
        </div>

        <div className='md:hidden fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 gap-4 flex flex-row'>
          <button className='btn btn-primary rounded-full shadow-xl px-6'>
            New Activity
          </button>

          <button className='btn btn-primary rounded-full shadow-xl w-10 h-10 p-0 flex items-center justify-center'>
            <IconShare className='w-5 h-5' />
          </button>
        </div>
      </main>
    </div>
  )
}