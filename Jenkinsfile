/* Requires the Docker Pipeline plugin , environment*/
pipeline {
    agent any

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