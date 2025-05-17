import { Routes, Route } from 'react-router-dom'
import Home from '../pages/home'
import Room from '../pages/room'
import About from '../pages/about'
import NotFound from '../pages/not-found'

export default function AppRoutes() {
  return (
    <Routes>
      <Route path="/" element={<Home />} />
      <Route path="/sign-up" element={<About />} />
      <Route path="/room/:id" element={<Room />} />
      <Route path="/about" element={<About />} />
      <Route path="*" element={<NotFound />} />
    </Routes>
  )
}
