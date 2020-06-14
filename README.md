# Prep OS
```
sudo snap install microk8s --classic --channel=1.18/stable
sudo usermod -a -G microk8s $USER
sudo chown -f -R $USER ~/.kube

su - $USER
microk8s start
microk8s status --wait-ready
microk8s kubectl get nodes
microk8s kubectl get services
microk8s config > ~/.kube/config
echo "alias kubectl='microk8s kubectl'" > ~/.bash_aliases
microk8s enable metallb storage dns registry dashboard helm3
```

Input an ip range in the same range as the VM
```
# 192.168.58.150-192.168.58.200
```

## Add insecure registry to docker
```
sudo nano /etc/docker/daemon.json
```
```
# /etc/docker/daemon.json
{
  "insecure-registries" : ["localhost:32000", "platform.net:32000"]
}
```
```
sudo systemctl restart docker
```
Dashboard Token
```
token=$(microk8s kubectl -n kube-system get secret | grep default-token | cut -d " " -f1)
microk8s kubectl -n kube-system describe secret $token
```

Install demo prerequisites & build required images online
```
kubectl apply -f metric-server/1.8+/
```

# Prep Images
Build all images for demo and push to local registry
```
docker pull busybox
docker tag busybox:latest localhost:32000/busybox
docker push localhost:32000/busybox:latest

docker build -t localhost:32000/pod:v1 pod_v1
docker push  localhost:32000/pod:v1

docker build -t localhost:32000/pod:v2 pod_v2
docker push  localhost:32000/pod:v2
```
Save and load for offline if required
```
docker save localhost:32000/busybox:latest -o busybox.tar
docker save  localhost:32000/pod:v1 -o pod_v1.tar
docker save  localhost:32000/pod:v2 -o pod_v2.tar

docker load -i busybox.tar
docker load -i pod_v1.tar
docker load -i pod_v2.tar
```

Clean Up environment
```
kubectl delete -f .
```

Optional: Install KubeInvaders
```
helm repo add kubeinvaders https://lucky-sideburn.github.io/helm-charts/
helm repo update
helm del -n kubeinvaders kubeinvaders
helm install kubeinvaders --set-string target_namespace="default" --namespace kubeinvaders kubeinvaders/kubeinvaders
```

# Storytime
Clean Up environment
```
kubectl delete -f .
```

## Desired State Demo
Start up 1 pod using a document that contains all information about how to run this application.
```
kubectl apply -f 1_deploy_1_v1_pod.yaml
kubectl get pods
kubectl get deploy --watch
```

> Kubernetes carries out all activities required to run the workload as described in the manifest, just like how an administrator would follow a proceedure or document to provision and configure a service. 

Manual scaling to 2 pods by instructing Kubernetes directly.
```
kubectl scale --replicas=2 deployment/php-apache
kubectl get pods
kubectl get deploy --watch
```

Scaling to 4 pods by using a manifest. This has the benfits of being able to version and track actions done to the application.
```
kubectl apply -f 2_scale_to_4_pods.yaml
kubectl get pods
kubectl get deploy --watch
```

In another shell for ease of observation of deployment status do:
```
kubectl get deploy --watch
```

Kill a random pod
```
kubectl scale --replicas=2 deployment/php-apache
```

> Unlike an administrator, Kubernetes doesn't get tired, is able to perform actions faster and doesn't make any mistakes executing instructions. It also enables best practices from operations and security to be added to the developers code without having developers be experts in those areas. 

## Autoscaling Demo
> Being able to deploy and scale by defining the end state or intent is great but probably not as great if a human has to make decisions about how many instances of the application, or pods, should be running during busy periods. Kubernetes can do that for us. So we need to give Kubernetes some boundaries within which it can scale up the resources or the number of pods automatically based on some metric such as CPU.

```
kubectl apply -f 3_set_autoscale_pods.yaml
kubectl get hpa --watch

# Generate Load
while true; do wget -q -O- http://192.168.58.150/load.php; echo ""; done

```

## Zero-Downtime Updates

Rolling upgrade to pod v2
```
kubectl apply -f 4_upgrade_to_v2_pods.yaml

kubectl rollout status deployment php-apache
```
