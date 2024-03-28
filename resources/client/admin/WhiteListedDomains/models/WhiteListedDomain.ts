
export interface WhiteListedDomain {
    id: number,
    name: string
    created_at?: string
}

export interface WhiteListedDomainPayload {
    name : string
}

export const URL = 'white-listed-domains';