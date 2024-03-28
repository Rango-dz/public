
export const title_types: string[] = ['movie', 'series'];

export const id_type: string[] = ['imdb', 'tmdb', 'iwo']

export const categories: string[] = ['trailer', 'clip', 'movie', 'episode']

export const video_type: string[] = ['embed', 'url', 'direct']

export const quality: string[] = ['sd', 'hd', '720p', '1080p', '4k']

export const video_category: string[] = ['trailer', 'clip', 'movie', 'episode']

export const STORE_URL: string = 'users/video-management/links';



export type FormValues = {
    language: string,
    quality: 'sd' | 'hd' | '720p' | '1080p' | '4k',
    video_type: 'embed' | 'url' | 'direct',
    video_category: 'trailer' | 'clip' | 'movie' | 'episode',
    src: string
}