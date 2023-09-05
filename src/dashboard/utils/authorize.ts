import axios from "axios";

export default async function getPerm() {
    try {
        const response = await axios({
            url: "/api/dashboard/users/get-perm.php",
            method: "post",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        });

        return response.data;
    } catch (error) {
        console.error("Error fetching data:", error);
    }
}
