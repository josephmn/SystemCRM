using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListadoDocumentosPersonal : BDconexion
    {
        public List<EListadoDocumentosPersonal> Listar_ListadoDocumentosPersonal(String dni)
        {
            List<EListadoDocumentosPersonal> lCListadoDocumentosPersonal = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListadoDocumentosPersonal oVListadoDocumentosPersonal = new CListadoDocumentosPersonal();
                    lCListadoDocumentosPersonal = oVListadoDocumentosPersonal.Listar_ListadoDocumentosPersonal(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListadoDocumentosPersonal);
        }
    }
}