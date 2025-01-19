export function subscribeToMercure(topic: string, onMessage: (data: any) => void): EventSource {
    console.log(import.meta.env.VITE_MERCURE_URL)
    const url = new URL(import.meta.env.VITE_MERCURE_URL);
    url.searchParams.append('topic', topic);
    url.searchParams.append('jwt',import.meta.env.MERCURE_JWT);
    const eventSource = new EventSource(url.toString());

    eventSource.onmessage = (event) => {
        try {
            const data = JSON.parse(event.data);
            onMessage(data);
        } catch (error) {
            console.error('Error parse:', error);
        }
    };

    eventSource.onerror = (error) => {
        console.error('Error connecting:', error);
    };

    return eventSource;
}
