using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VCertificadoCts : BDconexion
    {
        public List<ECertificadoCts> Listar_CertificadoCts(Int32 post, String dni, String periodo)
        {
            List<ECertificadoCts> lCCertificadoCts = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CCertificadoCts oVCertificadoCts = new CCertificadoCts();
                    lCCertificadoCts = oVCertificadoCts.Listar_CertificadoCts(con, post, dni, periodo);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCCertificadoCts);
        }
    }
}