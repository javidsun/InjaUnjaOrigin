import travelersData from '../docs/TravelersContent.json';

export default {
    getTravelers() {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve(travelersData.travelers);
            }, 500); // Simulate API delay
        });
    },

    getTravelIcons() {
        return travelersData.travelIcons;
    },

    getMarkerIcons() {
        return travelersData.markerIcons;
    },

    loadMoreTravelers() {
        return new Promise((resolve) => {
            setTimeout(() => {
                const newTravelers = [
                    {
                        id: 10,
                        destination: "Prague, Czech Republic",
                        user: {
                            name: "Nader",
                            age: 31,
                            gender: "male",
                            rating: 4.8
                        },
                        travelDates: "2025 April 02-15",
                        budget: "1100",
                        travelStyle: "cultural",
                        description: "Interested in photographing historical architecture",
                        image: "/1010.png",
                        images: ["/1030.png"],
                        coordinates: [50.0755, 14.4378],
                        personalityTraits: ["creative", "passionate", "tasteful"]
                    }
                ];
                resolve(newTravelers);
            }, 1000);
        });
    },

    sendContactRequest(requestData) {
        return new Promise((resolve) => {
            setTimeout(() => {
                resolve({ success: true, message: "Request sent successfully" });
            }, 1500);
        });
    }
};
