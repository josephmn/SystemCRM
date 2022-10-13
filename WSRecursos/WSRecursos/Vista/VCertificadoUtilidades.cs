using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCertificadoUtilidades : BDconexion
    {
        public List<ECertificadoUtilidades> Listar_CertificadoUtilidades(Int32 anhio, String dni)
        {
            List<ECertificadoUtilidades> lCCertificadoUtilidades = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCertificadoUtilidades oVCertificadoUtilidades = new CCertificadoUtilidades();
                    lCCertificadoUtilidades = oVCertificadoUtilidades.Listar_CertificadoUtilidades(con, anhio, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCertificadoUtilidades);
        }
    }
}