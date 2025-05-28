document.addEventListener('DOMContentLoaded', function() {
    // Initialize charts if data exists
    if (cycleData && cycleData.length > 0) {
        initializeCharts();
        updateStats();
    }

    // Handle form submission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateForm()) {
                return;
            }

            // Submit form
            const formData = new FormData(form);
            fetch('process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    updateCharts(data.cycleData);
                    updateStats();
                    form.reset();
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                showMessage('error', 'An error occurred. Please try again.');
                console.error('Error:', error);
            });
        });
    }

    // Handle symptom tags
    const symptomTags = document.querySelectorAll('.symptom-tag');
    symptomTags.forEach(tag => {
        tag.addEventListener('click', function() {
            this.classList.toggle('active');
            updateSelectedSymptoms();
        });
    });

    // Handle notes saving
    const notesTextarea = document.getElementById('notes');
    if (notesTextarea) {
        notesTextarea.addEventListener('blur', saveNotes);
    }
});

function validateForm() {
    const lastPeriod = document.getElementById('last_period').value;
    const cycleLength = document.getElementById('cycle_length').value;
    const mood = document.querySelector('input[name="mood"]:checked');
    const flow = document.querySelector('input[name="flow"]:checked');

    if (!lastPeriod) {
        showMessage('error', 'Please select your last period date');
        return false;
    }

    if (!cycleLength || cycleLength < 21 || cycleLength > 35) {
        showMessage('error', 'Please enter a valid cycle length (21-35 days)');
        return false;
    }

    if (!mood) {
        showMessage('error', 'Please select your mood');
        return false;
    }

    if (!flow) {
        showMessage('error', 'Please select your flow intensity');
        return false;
    }

    return true;
}

function showMessage(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    const container = document.querySelector('.tracker-container');
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

function initializeCharts() {
    // Cycle Length Chart
    const cycleCtx = document.getElementById('cycleChart').getContext('2d');
    new Chart(cycleCtx, {
        type: 'line',
        data: {
            labels: cycleData.map(entry => new Date(entry.last_period).toLocaleDateString()),
            datasets: [{
                label: 'Cycle Length',
                data: cycleData.map(entry => entry.cycle_length),
                borderColor: '#ff69b4',
                backgroundColor: 'rgba(255, 105, 180, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Cycle Length History'
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    min: 20,
                    max: 36
                }
            }
        }
    });

    // Symptom Analysis Chart
    const symptomCtx = document.getElementById('symptomChart').getContext('2d');
    const symptoms = ['cramps', 'headache', 'bloating', 'tender_breasts', 'acne', 'fatigue'];
    const symptomData = symptoms.map(symptom => {
        return cycleData.filter(entry => {
            const entrySymptoms = JSON.parse(entry.symptoms || '[]');
            return entrySymptoms.includes(symptom);
        }).length;
    });

    new Chart(symptomCtx, {
        type: 'radar',
        data: {
            labels: symptoms.map(s => s.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())),
            datasets: [{
                label: 'Symptom Frequency',
                data: symptomData,
                backgroundColor: 'rgba(255, 105, 180, 0.2)',
                borderColor: '#ff69b4',
                pointBackgroundColor: '#ff69b4',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#ff69b4'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Symptom Analysis'
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: cycleData.length
                }
            }
        }
    });
}

function updateStats() {
    if (cycleData.length > 0) {
        const latestEntry = cycleData[0];
        
        // Update Next Period
        const nextPeriod = document.getElementById('next-period');
        if (nextPeriod) {
            nextPeriod.textContent = new Date(latestEntry.next_period).toLocaleDateString();
        }

        // Update Fertile Window
        const fertileWindow = document.getElementById('fertile-window');
        if (fertileWindow) {
            fertileWindow.textContent = `${new Date(latestEntry.fertile_start).toLocaleDateString()} - ${new Date(latestEntry.fertile_end).toLocaleDateString()}`;
        }

        // Update Average Cycle Length
        const avgCycle = document.getElementById('avg-cycle');
        if (avgCycle) {
            const avg = cycleData.reduce((sum, entry) => sum + entry.cycle_length, 0) / cycleData.length;
            avgCycle.textContent = `${avg.toFixed(1)} days`;
        }
    }
}

function updateCharts(newData) {
    cycleData.unshift(newData);
    if (cycleData.length > 6) {
        cycleData.pop();
    }
    
    // Remove existing charts
    const cycleChart = document.getElementById('cycleChart');
    const symptomChart = document.getElementById('symptomChart');
    cycleChart.parentNode.removeChild(cycleChart);
    symptomChart.parentNode.removeChild(symptomChart);
    
    // Create new canvas elements
    const cycleCanvas = document.createElement('canvas');
    cycleCanvas.id = 'cycleChart';
    const symptomCanvas = document.createElement('canvas');
    symptomCanvas.id = 'symptomChart';
    
    // Add new canvas elements to the container
    const chartsContainer = document.querySelector('.charts-container');
    chartsContainer.appendChild(cycleCanvas);
    chartsContainer.appendChild(symptomCanvas);
    
    // Initialize new charts
    initializeCharts();
}

function updateSelectedSymptoms() {
    const selectedSymptoms = Array.from(document.querySelectorAll('.symptom-tag.active'))
        .map(tag => tag.textContent.trim());
    document.getElementById('selectedSymptoms').value = selectedSymptoms.join(',');
}

function getSelectedSymptoms() {
    return document.getElementById('selectedSymptoms').value;
}

function saveNotes() {
    const notes = document.getElementById('notes').value;
    
    fetch('tracker/process.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: 'save_notes',
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showMessage('success', 'Notes saved successfully');
        } else {
            showMessage('error', 'Failed to save notes');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('error', 'Failed to save notes');
    });
} 