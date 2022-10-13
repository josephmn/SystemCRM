using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VRecuperarCorreo : BDconexion
    {
        public List<ERecuperarCorreo> Listar_RecuperarCorreo(String correo)
        {
            List<ERecuperarCorreo> lCRecuperarCorreo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CRecuperarCorreo oVRecuperarCorreo = new CRecuperarCorreo();
                    lCRecuperarCorreo = oVRecuperarCorreo.Listar_RecuperarCorreo(con, correo);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCRecuperarCorreo);
        }
    }
}