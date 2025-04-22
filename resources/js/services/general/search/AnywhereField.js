import axios from "axios";

export async function sendLocationSelection(location) {
    try {
        const response = await axios.post("/api/anywhere", {
            location: location
        });

        return response.data;
    } catch (error) {
        console.error("Error sending location:", error);
        throw error;
    }
}
