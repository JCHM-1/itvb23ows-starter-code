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
        stage('SonarQube Analysis') {
            steps{
                def scannerHome = tool 'sonarcube_jenkins';
                withSonarQubeEnv() {
                sh "${scannerHome}/bin/sonar-scanner"
                }
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