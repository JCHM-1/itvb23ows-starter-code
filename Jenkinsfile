/* Requires the Docker Pipeline plugin , environment*/
pipeline {
    agent {
        docker { image 'php:8.3.0-alpine3.18' } 
    }

    stages {
        stage('Build') {
            steps {
                sh 'php --version'
                echo "Building..."
                echo "Hello World"
                echo "The build ID of this job is ${BUILD_ID}"
            }
        }
        stage('Test') {
            steps {
                echo "Testing..."
            }
        }
        stage('Deliver') {
            steps {
                echo "Delivering..."
            }
        }
    }
    post {
        success {
            echo 'This will run only if successful'
        }
        failure {
            echo 'This will run only if failed'
        }
    }
}