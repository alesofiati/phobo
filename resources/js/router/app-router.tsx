import React from 'react'
import { Routes, Route } from 'react-router-dom'
import Room from '../pages/room'
import NotFound from '../pages/not-found'
import SignIn from '../pages/sign-in'

export default function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<SignIn />} />
      <Route path="/sala/:id" element={<Room />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  )
}
