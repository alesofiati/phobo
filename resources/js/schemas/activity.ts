import { z } from "zod";

export const schema = z.object({ 
  id: z.number().optional(),
  user_id: z.number().optional(), 
  nick_name: z.string().min(1).max(255),
  room_code: z.string().optional(),
  room_id: z.number().optional(), 
  rating: z.number().min(1).max(5),
  description: z.string().min(1).max(255),
  image: z.union([
    z.string().url(),
    z.instanceof(File),
  ]).optional(),
  episode: z.number(),
  season: z.number(),
  created_at: z.date().optional(),
});

export type Activity = z.infer<typeof schema>;