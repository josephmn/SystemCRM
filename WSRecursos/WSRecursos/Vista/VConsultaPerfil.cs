using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VConsultaPerfil : BDconexion
    {
        public List<EConsultaPerfil> Listar_ConsultaPerfil(String dni)
        {
            List<EConsultaPerfil> lCConsultaPerfil = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CConsultaPerfil oVConsultaPerfil = new CConsultaPerfil();
                    lCConsultaPerfil = oVConsultaPerfil.Listar_ConsultaPerfil(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCConsultaPerfil);
        }
    }
}