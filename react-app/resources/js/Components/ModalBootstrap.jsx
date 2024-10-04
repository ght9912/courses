import React, { useState } from 'react';
import Button from 'react-bootstrap/Button';
import Modal from 'react-bootstrap/Modal';

export default function Example({modalTitle, modalContent, modalButtons, showProp,hideModal}) {
  const handleClose = () => hideModal();
  return (
    <>
      <Modal show={showProp} onHide={handleClose}>
        <Modal.Header >
          <Modal.Title>{modalTitle}</Modal.Title>
        </Modal.Header>
        <Modal.Body>{modalContent}</Modal.Body>
        <Modal.Footer>
            {modalButtons}
        </Modal.Footer>
      </Modal>
    </>
  );
}


