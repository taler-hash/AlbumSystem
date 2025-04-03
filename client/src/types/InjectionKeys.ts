import type { InjectionKey, Ref, WritableComputedRef } from "vue";

const getAlbumsKey = Symbol() as InjectionKey<(load: boolean) => void>
const filterSearchKey = Symbol() as InjectionKey<WritableComputedRef<string>>

export { getAlbumsKey, filterSearchKey }