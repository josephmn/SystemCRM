using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CConsultaPaPersonal
    {
        public List<EConsultaPaPersonal> ConsultaPaPersonal(SqlConnection con, String dni, String publicacion)
        {
            List<EConsultaPaPersonal> lEConsultaPaPersonal = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_PA_PERSONAL", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@publicacion", SqlDbType.VarChar).Value = publicacion;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConsultaPaPersonal = new List<EConsultaPaPersonal>();

                EConsultaPaPersonal obEConsultaPaPersonal = null;
                while (drd.Read())
                {
                    obEConsultaPaPersonal = new EConsultaPaPersonal();

                    obEConsultaPaPersonal.v_publicacion = drd["v_publicacion"].ToString();
                    obEConsultaPaPersonal.v_puesto = drd["v_puesto"].ToString();
                    obEConsultaPaPersonal.v_nombre = drd["v_nombre"].ToString();
                    obEConsultaPaPersonal.v_paterno = drd["v_paterno"].ToString();
                    obEConsultaPaPersonal.v_materno = drd["v_materno"].ToString();
                    obEConsultaPaPersonal.d_fnacimiento = drd["d_fnacimiento"].ToString();
                    obEConsultaPaPersonal.v_tipodocumento = drd["v_tipodocumento"].ToString();
                    obEConsultaPaPersonal.v_dni = drd["v_dni"].ToString();
                    obEConsultaPaPersonal.v_sexo = drd["v_sexo"].ToString();
                    obEConsultaPaPersonal.v_civil = drd["v_civil"].ToString();
                    obEConsultaPaPersonal.i_pais = drd["i_pais"].ToString();
                    obEConsultaPaPersonal.i_departamento = drd["i_departamento"].ToString();
                    obEConsultaPaPersonal.i_provincia = drd["i_provincia"].ToString();
                    obEConsultaPaPersonal.i_distrito = drd["i_distrito"].ToString();
                    obEConsultaPaPersonal.v_domicilio = drd["v_domicilio"].ToString();
                    obEConsultaPaPersonal.v_celular = drd["v_celular"].ToString();
                    obEConsultaPaPersonal.v_correo = drd["v_correo"].ToString();
                    obEConsultaPaPersonal.i_hijos = drd["i_hijos"].ToString();
                    obEConsultaPaPersonal.i_essalud = drd["i_essalud"].ToString();
                    obEConsultaPaPersonal.v_essalud = drd["v_essalud"].ToString();
                    obEConsultaPaPersonal.i_domiciliado = drd["i_domiciliado"].ToString();
                    obEConsultaPaPersonal.v_afp = drd["v_afp"].ToString();
                    obEConsultaPaPersonal.v_comfluapf = drd["v_comfluapf"].ToString();
                    obEConsultaPaPersonal.v_codafp = drd["v_codafp"].ToString();
                    obEConsultaPaPersonal.i_regimen = drd["i_regimen"].ToString();
                    obEConsultaPaPersonal.i_niveleducacion = drd["i_niveleducacion"].ToString();
                    obEConsultaPaPersonal.i_discapacidad = drd["i_discapacidad"].ToString();

                    lEConsultaPaPersonal.Add(obEConsultaPaPersonal);
                }
                drd.Close();
            }

            return (lEConsultaPaPersonal);
        }
    }
}