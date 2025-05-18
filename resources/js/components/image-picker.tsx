import React from 'react'
import { useState } from 'react'

interface Props {
  imageUrl?: string
  onLoadImage: (image: File) => void
}

export default function ImagePicker({
  imageUrl,
  onLoadImage
}: Props) {
  const [fileBlob, setFileBlob] = useState<string | undefined>()

  const handleImageUpload = async (e: React.ChangeEvent<HTMLInputElement>) => {
    const currentFile = e.target.files?.[0]
    if (!currentFile) return

    onLoadImage(currentFile)
    setFileBlob(URL.createObjectURL(currentFile))
  }

  return (
    <div
      className='relative border border-white/20 flex cursor-pointer items-center justify-center overflow-hidden aspect-video rounded-lg'
      onClick={() => document.getElementById('image-upload')?.click()}
    >
      <img
        src={fileBlob || imageUrl || '/images/logo-sm.svg'}
        alt='Image cover'
        className='h-full w-full object-cover'
      />

      <input
        id='image-upload'
        type='file'
        accept='image/*'
        className='hidden'
        onChange={handleImageUpload}
      />

      <div className='absolute bottom-4 left-4'>
        <button type='button' className='btn btn-outline btn-sm btn-soft gap-2'>
          Adiciona capa
        </button>
      </div>
    </div>
  )
}
