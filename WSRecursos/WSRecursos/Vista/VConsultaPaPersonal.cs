using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConsultaPaPersonal : BDconexion
    {
        public List<EConsultaPaPersonal> ConsultaPaPersonal(String dni, String publicacion)
        {
            List<EConsultaPaPersonal> lCConsultaPaPersonal = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConsultaPaPersonal oVConsultaPaPersonal = new CConsultaPaPersonal();
                    lCConsultaPaPersonal = oVConsultaPaPersonal.ConsultaPaPersonal(con, dni, publicacion);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConsultaPaPersonal);
        }
    }
}