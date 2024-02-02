/* Requires the Docker Pipeline plugin , environment*/
pipeline {
    agent any

    stages {
        stage('Build') {
            steps {
                echo "The build ID of this job is ${BUILD_ID}"
            }
        }
        stage('SonarQube') {
            steps {
                script { scannerHome = tool 'sonarqube_jenkins' }
                    withSonarQubeEnv('sonarqube_jenkins') {
                        sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=OWS-sonarcube"
                }
            }   
        }
        stage('Docker Compose Up') {
            steps {
                script {
                    sh 'docker-compose up --build -d'
                }
            }
        }
        stage('tests') {
            steps {
                sh 'docker exec -it vendor/bin/phpunit'
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