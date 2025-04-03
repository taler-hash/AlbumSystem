interface RoleTypes {
    id?: number,
    name: string, 
}

export interface UserTypes {
    username: string,
    name: string,
    password?: string,
    id?: number,
    roles?: RoleTypes[]
}