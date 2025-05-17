import React from 'react'
import { Routes, Route } from 'react-router-dom'
import Home from '../pages/home'
import About from '../pages/about'
import Room from '../pages/room'
import NotFound from '../pages/not-found'
import SignIn from '../pages/sign-in'

export default function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/sign-in" element={<SignIn />} />
      <Route path="/room/:id" element={<Room />} />
      <Route path="/about" element={<About />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  )
}
