/* Requires the Docker Pipeline plugin , environment*/
pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
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
        stage('SonarQube') {
            steps {
                script { scannerHome = tool 'SonarQube Scanner' }
                withSonarQubeEnv('SonarQube') {
                    sh "${scannerHome}/bin/sonar-scanner-Dsonar.projectKey=[key]"
                }
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