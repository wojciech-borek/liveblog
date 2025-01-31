interface MercureMessage {
    data: unknown;
    type: string;
    id?: string;
}
export function subscribeToMercure(topic: string, onMessage: (data: MercureMessage) => void): EventSource {
    const url = new URL(import.meta.env.VITE_MERCURE_URL);
    url.searchParams.append('topic', topic);
    const eventSource = new EventSource(url.toString(), {});

    eventSource.onmessage = (event) => {
        try {
            const data = JSON.parse(event.data);
            onMessage({
                data,
                type: event.type,
                id: event.lastEventId
            });
        } catch (error) {
            console.error('Failed to parse SSE message:', error);
        }
    };
    eventSource.onerror = (error) => {
        console.error('SSE connection error:', error);
        eventSource.close();
    };
    return eventSource;
}