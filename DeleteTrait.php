<?php

namespace App\Controller\Traits;

trait DeleteTrait
{

    public function setDeleteOutcomeMessages($modelClassAlias)
    {
        $this->deleteTraitMessages = [
           'success' => __('The {0} has been deleted.', $modelClassAlias),
           'failure' => __('The {0} could not be deleted. Please, try again.', $modelClassAlias)
        ];
    }

    public function setDeleteModelClassAlias()
    {
        $this->modelClassAlias = explode(".", $this->modelClass);
        $this->modelClassAlias = $this->modelClassAlias[count($this->modelClassAlias) - 1];
    }

    /**
     * Delete method
     *
     * @param string|null $id Entity id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->setDeleteModelClassAlias();
        $this->setDeleteOutcomeMessages($this->modelClassAlias);
        $this->request->allowMethod(['post', 'delete']);
        $recordEntity = $this->{$this->modelClassAlias}->get($id);

        if ($this->{$this->modelClassAlias}->delete($recordEntity)) {
            $this->Flash->success($this->deleteTraitMessages['success']);
        } else {
            $this->Flash->error(
                $this->deleteTraitMessages['failure'],
                ['params' => ['errors' => $recordEntity->errors()]]
            );
        }
        return $this->redirect(['action' => 'index']);
    }
}
