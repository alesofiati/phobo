import axios, { AxiosError } from 'axios'

export class ErrorBag extends Error {
  public message: string
  public errors: Record<string, string[]>
  public status: number

  constructor(error: {
    message: string
    errors: Record<string, string[]>
    status: number
  }) {
    super(error.message)
    this.message = error.message
    this.errors = error.errors
    this.status = error.status
  }
}

const apiClient = axios.create({
  baseURL: '/',
})

apiClient.interceptors.request.use((config) => {
  // https://stackoverflow.com/questions/50691938/patch-and-put-request-does-not-working-with-form-data
  if (config.data instanceof FormData && config.method) {
    config.data.append('_method', config.method!.toUpperCase())
    config.method = 'post'
  }

  return config
})

apiClient.interceptors.response.use(
  (response) => response.data,
  (error) => {
    if (error instanceof AxiosError) {
      throw new ErrorBag({
        message: error.response?.data.message,
        errors: error.response?.data.errors,
        status: error.status ?? 500,
      })
    }

    throw error
  }
)

export default apiClient
