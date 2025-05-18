import React, { useState } from 'react'
import { Activity } from '../schemas/activity'
import apiClient from '../libs/api-client'
import { toast } from 'react-toastify'

interface NewActivityDialogProps {
  setIsDialogOpen: React.Dispatch<React.SetStateAction<boolean>>
  isDialogOpen: boolean
  onSave: (activity: Activity) => void
  onClose: () => void
}

const NewActivityDialog: React.FC<NewActivityDialogProps> = ({ setIsDialogOpen, isDialogOpen, onSave, onClose }) => {
  const [activityData, setActivityData] = useState<Activity>({
    nick_name: localStorage.getItem('nickname') || '',
    room_code: localStorage.getItem('room_id') || '',
    description: '',
    episode: 0,
    season: 0,
    rating: 0,
  })

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    const { name, value } = e.target
    setActivityData(prevState => ({
      ...prevState,
      [name]: value,
    }))
  }

  const handleSaveActivity = async () => {
    try {
      await apiClient.post('/api/activities', activityData)
      toast.success('Atividade adicionada com sucesso!')
      onSave(activityData)
      onClose()
    } catch (error) {
      toast.error('Erro ao adicionar a atividade.')
      console.error(error)
    }
  }

  return (
    <div className={`fixed inset-0 z-50 flex justify-center items-center bg-gray-800 bg-opacity-50 ${!isDialogOpen && 'hidden'}`}>
      <div className="modal modal-open">
        <div className="modal-box">
          <h2 className="text-xl font-bold mb-4">Adicionar Atividade</h2>

          <div className="form-control mb-4">
            <label htmlFor="description" className="label">
              <span className="label-text">Descrição</span>
            </label>
            <textarea
              id="description"
              name="description"
              className="textarea textarea-bordered w-full"
              value={activityData.description}
              onChange={handleInputChange}
            />
          </div>

          <div className="form-control mb-4">
            <label htmlFor="episode" className="label">
              <span className="label-text">Episódio</span>
            </label>
            <input
              id="episode"
              name="episode"
              type="number"
              className="input input-bordered w-full"
              value={activityData.episode}
              onChange={handleInputChange}
            />
          </div>

          <div className="form-control mb-4">
            <label htmlFor="season" className="label">
              <span className="label-text">Temporada</span>
            </label>
            <input
              id="season"
              name="season"
              type="number"
              className="input input-bordered w-full"
              value={activityData.season}
              onChange={handleInputChange}
            />
          </div>

          <div className="form-control mb-4">
            <label htmlFor="rating" className="label">
              <span className="label-text">Avaliação</span>
            </label>
            <input
              id="rating"
              name="rating"
              type="number"
              className="input input-bordered w-full"
              value={activityData.rating}
              onChange={handleInputChange}
              min="0"
              max="5"
            />
          </div>

          <div className="modal-action">
            <button className="btn btn-primary" onClick={handleSaveActivity}>
              Salvar
            </button>
            <button className="btn" onClick={onClose}> {/* Fechar o modal ao clicar no botão "Fechar" */}
              Fechar
            </button>
          </div>
        </div>
      </div>
    </div>
  )
}

export default NewActivityDialog
