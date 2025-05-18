import React, { useState } from 'react'
import { IconShare } from '@tabler/icons-react'
import { Activity } from '../schemas/activity'
import { AnimatePresence } from 'framer-motion'
import confetti from 'canvas-confetti'
import ActivityCard from '../components/activity-card'
import { toast } from 'react-toastify'
import { useNavigate, useParams } from 'react-router-dom'
import apiClient from '../libs/api-client'
import { RoomSchema } from '../schemas/room'
import RoomCard from '../components/room-card'
import UserCard from '../components/user-card'
import NewActivityDialog from '../components/new-activity-dialog'

export default function Room() {
  const { id } = useParams<{ id: string }>()

  const [room, setRoom] = useState<RoomSchema | null>(null)
  const [activities, setActivities] = useState<Activity[]>([])
  const [isDialogOpen, setIsDialogOpen] = useState(false)
  const navigate = useNavigate()
  
  const newActivityButtonRef = React.useRef<HTMLButtonElement>(null)
  const newActivityButtonMobileRef = React.useRef<HTMLButtonElement>(null)

  const showButtonConfetti = (ref: React.RefObject<HTMLButtonElement | null>) => { 
    const rect = ref.current?.getBoundingClientRect()
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

  const hasFetched = React.useRef(false)

  React.useEffect(() => {
    const fetchRoom = async () => {
      if (hasFetched.current) return
      hasFetched.current = true

      try {
        const response = await apiClient.get(`/api/rooms/${id}`, {
          params: {
            nick_name: localStorage.getItem('nickname'),
          }
        })
        setRoom(response)
      } catch (error) {
        toast.error("Não conseguimos encontrar a sala!", { 
          position: 'bottom-center',
        })
        navigate('/')
        console.error('Error fetching room data:', error)
      }
    }

    fetchRoom()
  }, [id])

  const handleNewActivity = (ref: React.RefObject<HTMLButtonElement | null>) => { 
    setIsDialogOpen(true)
  }

  const handleShare = async () => { 
    await navigator.clipboard.writeText(window.location.href)
    toast("O link da sala foi copiado para a área de transferência!", {
      type: 'success',
      position: 'bottom-center',
    })
  }

  const handleSaveActivity = (activity: Activity) => {
    setActivities(prev => [activity, ...prev])
    showButtonConfetti(newActivityButtonMobileRef.current ? newActivityButtonRef : newActivityButtonMobileRef)
  }

  const handleCloseModal = () => {
    setIsDialogOpen(false) 
  }

  return (
    <div className='w-screen min-h-screen flex flex-col'>
      <div className="navbar fixed top-0 left-0 right-0 z-50 bg-base-300 shadow-sm justify-center">
        <a href='/'><img src='/images/logo.svg' className='h-10'/></a>
      </div>

      <main className="w-full md:max-w-4xl mx-auto flex flex-row gap-8 h-full p-4 pt-24">
        <div className='hidden md:flex flex-col w-96 gap-6 sticky top-24 self-start h-fit z-10'>
          {room && <RoomCard room={room}/>}
          {room?.nick_name && <UserCard nick_name={room.nick_name}/>}
          
          <button ref={newActivityButtonRef} onClick={() => handleNewActivity(newActivityButtonRef)} className='btn h-12 btn-primary rounded-lg shadow-xl'>
            Eu assisti mais um episódio
          </button>

          {/* <button onClick={handleShare} className='btn h-12 rounded-lg shadow-xl'>
            Compartilhar
          </button> */}
        </div>

        <div className='flex flex-col gap-6 w-full'>
          <div className='md:hidden w-full gap-6 flex flex-col'>
            {room && <RoomCard room={room}/>}
            {room?.nick_name && <UserCard nick_name={room.nick_name}/>}
          </div>

          <p className='block text-xl md:text-2xl font-bold'>
            Atividade
          </p>

          {activities.length === 0 && (
            <div className='card bg-base-300 shadow-xl p-4 gap-4 flex flex-row'>
              <p className="text-center text-slate-500 text-sm">
                Não há atividades registradas ainda.
              </p>
            </div>
          )}

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
          <button ref={newActivityButtonMobileRef} onClick={() => handleNewActivity(newActivityButtonMobileRef)} className='btn btn-primary rounded-full shadow-xl px-6'>
            Eu assisti mais um episódio
          </button>

          <button onClick={handleShare} className='btn btn-primary rounded-full shadow-xl w-10 h-10 p-0 flex items-center justify-center'>
            <IconShare className='w-5 h-5' />
          </button>
        </div>
      </main>

      <NewActivityDialog
        setIsDialogOpen={setIsDialogOpen}
        isDialogOpen={isDialogOpen}
        onSave={handleSaveActivity}
        onClose={handleCloseModal}
      />
    </div>
  )
}
