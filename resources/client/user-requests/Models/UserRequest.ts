import { Title } from "@app/titles/models/title";

export interface UserRequest {
    id: number;
    title_id : number;
    title?: Title;
    description?: string;
    user_id?: number;
    season_no?: number;
    episode_no?: number;
    updated_at?: string;
    created_at?: string;
}

export const POST_URL: string = 'user-requests';

export const GET_URL: string = 'user-requests';

