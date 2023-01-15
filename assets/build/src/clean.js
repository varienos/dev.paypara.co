import { deleteAsync } from 'del';
export const clean = () => deleteAsync(["assets/build/dist/**"], { force: true });
