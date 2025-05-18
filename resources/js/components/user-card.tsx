import React from 'react'

interface Props {
  nick_name: string;
}

export default function UserCard({ nick_name }: Props) { 
  const getDiceBearAvatar = (seed: string) => { 
    return `https://api.dicebear.com/9.x/avataaars-neutral/svg?seed=${seed}&eyebrows=default,defaultNatural,flatNatural,frownNatural,raisedExcited,raisedExcitedNatural,upDown,upDownNatural&eyes=default,happy,hearts,squint,surprised,wink,winkWacky,closed&mouth=default,eating,smile,tongue,twinkle`
  }

  return (
    <div className='card bg-white shadow-xl p-4'>
      <div className="flex flex-row items-center gap-2 text-slate-500"> 
        <img
          className="w-6 h-6 rounded-md"
          src={getDiceBearAvatar(nick_name)}
          alt="avatar" 
        />

        {nick_name} (criador)
      </div>
    </div>
  )
}