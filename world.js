let DOM_LOADED = false;
const queuedJobs = [];

document.addEventListener('DOMContentLoaded', () => {
    DOM_LOADED = true;
    while (queuedJobs.length)
        queuedJobs.pop()();
});

const work = (job) => {
    if (DOM_LOADED)
        return job();
    queuedJobs.push(job);
}

work(() => {
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookup_cities");
    const countryInput = document.getElementById("country");

    const doLookup = async (searchParams) => {
        try {
            const res = await fetch(`world.php?${new URLSearchParams(searchParams)}`)
            const html = await res.text()

            const resultDiv = document.getElementById("result")
            resultDiv.innerHTML = html
        } catch (e) {
            console.error(e)
        }
    }

    lookupButton.addEventListener("click", async () =>
        doLookup({country: countryInput.value})
    )

    lookupCitiesButton.addEventListener("click", async () =>
        doLookup({country: countryInput.value, lookup: "cities"})
    )

})