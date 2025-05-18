import { z } from "zod";

export const schema = z.object({ 
  id: z.number().optional(),
  code: z.string().optional(),
  nick_name: z.string().optional(),
  name: z.string().optional(),
  file_url: z.string().optional(),
  created_at: z.date().optional(),
});

export type RoomSchema = z.infer<typeof schema>;