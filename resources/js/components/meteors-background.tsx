import React, { useMemo } from 'react'
import { motion } from 'framer-motion'

export default function MeteorsBackground() {
  const items = useMemo(() => {
    return new Array(30).fill(null).map((_, i) => ({
      key: i,
      top: `${Math.random() * 100}%`,
      width: `${30 + Math.random() * 60}px`,
      height: `${20 + Math.random() * 60}px`,
      duration: 8 + Math.random() * 6,
      delay: Math.random() * 5,
      color: `rgba(255, 255, 255, ${0.05 + Math.random() * 0.1})`,
    }))
  }, [])

  return (
    <div className="absolute inset-0 z-0 pointer-events-none overflow-hidden">
      {items.map((item) => (
        <motion.div
          key={item.key}
          className="absolute rounded-xl"
          style={{
            top: item.top,
            width: item.width,
            height: item.height,
            backgroundColor: item.color,
          }}
          initial={{ x: '-20vw' }}
          animate={{ x: '120vw' }}
          transition={{
            repeat: Infinity,
            repeatType: 'loop',
            duration: item.duration,
            delay: item.delay,
            ease: 'linear',
          }}
        />
      ))}
    </div>
  )
}
