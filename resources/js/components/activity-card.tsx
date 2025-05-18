import React from 'react'
import { motion } from "framer-motion";
import { Activity } from "../schemas/activity";
import { IconStarFilled } from "@tabler/icons-react";

interface Props { 
  activity: Activity
}

export default function ActivityCard({ activity }: Props) { 
  const getDiceBearAvatar = (seed: string) => { 
    return `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${seed}&eyebrows=default,defaultNatural,flatNatural,frownNatural,raisedExcited,raisedExcitedNatural,upDown,upDownNatural&eyes=default,happy,hearts,squint,surprised,wink,winkWacky,closed&mouth=default,eating,smile,tongue,twinkle`
  }

  return (
    <motion.div
      key={activity.id}
      layout
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      exit={{ opacity: 0, y: -20 }}
      transition={{ duration: 0.3 }}
      className='card w-full min-h-12 bg-base-300 shadow-xl p-4 gap-4 flex flex-row'
    >
      <div className="flex flex-col gap-4 justify-between  w-full"> 
        <div className="flex flex-row items-center gap-2">
          {
            Array.from({ length: activity.rating }, (_, i) => (
              <IconStarFilled key={i} className="text-yellow-200" />
            )) 
          }
        </div>
        
        <p className="line-clamp-5">
          {activity.description}
        </p>
        
        <div className="flex flex-row items-center justify-between"> 
          <div className="flex flex-row items-center gap-2"> 
            <img
              className="w-6 h-6 rounded-md"
              src={getDiceBearAvatar(activity.nickname)}
              alt="avatar" 
            />

            {activity.nickname}
          </div>

          <div className="flex flex-row items-center gap-2 text-sm text-gray-500"> 
            (Temp. {activity.season} Ep. {activity.episode})

            {
              activity.created_at && <p>
                {new Date(activity.created_at).toLocaleDateString('pt-BR', {
                  year: 'numeric',
                  month: '2-digit',
                  day: '2-digit',
                })}
              </p>
            }
          </div>
        </div>
      </div>

      { 
        activity.image && <img
          className="w-30 max-h-40 rounded-md"
          src={activity.image instanceof File ? URL.createObjectURL(activity.image) : activity.image}
          alt="avatar" 
        />
      }
    </motion.div>
  )
}